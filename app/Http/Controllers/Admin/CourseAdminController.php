<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CourseRegistrationController;
use App\Models\CourseOffer;
use App\Models\CourseRegistration;
use App\Models\DiscountCode;
use App\Services\CenterSystem;
use App\Services\Deema;
use App\Services\MyFatoorah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CourseAdminController extends Controller
{
    // ─── Registrations ───

    public function registrations(Request $request)
    {
        if ($request->status === 'followup') {
            // One row per person and course: their latest unpaid attempt
            $registrations = CourseRegistration::needsFollowUp()->latest()->get()
                ->unique(fn ($r) => $r->phone . '|' . $r->course_key)->values();
        } else {
            $registrations = CourseRegistration::latest()
                ->when($request->status, fn ($q, $s) => $q->where('status', $s))
                ->get();
        }

        $all = CourseRegistration::query();
        $stats = [
            'total'   => (clone $all)->count(),
            'paid'    => (clone $all)->where('status', 'paid')->count(),
            'pending' => (clone $all)->where('status', 'pending')->count(),
            'revenue' => (float) (clone $all)->where('status', 'paid')->sum('final_amount'),
        ];

        $codes = DiscountCode::where('is_active', true)->whereNull('owner_registration_id')->get()->filter(fn ($c) => !$c->unusableReason($c->course_key ?? ''));

        return view('admin.registrations', compact('registrations', 'stats', 'codes'));
    }

    public function markFollowedUp(CourseRegistration $registration)
    {
        // Mark every unpaid attempt of this person for this course, so the list stays clean
        CourseRegistration::where('phone', $registration->phone)
            ->where('course_key', $registration->course_key)
            ->where('status', '!=', 'paid')
            ->update(['followed_up_at' => now()]);

        return back()->with('ok', "تم تسجيل متابعة {$registration->name}");
    }

    public function verify(CourseRegistration $registration, MyFatoorah $myFatoorah, Deema $deema)
    {
        if (!$registration->invoice_id) {
            return back()->with('error', 'لا يوجد رقم فاتورة لهذا التسجيل');
        }

        if ($registration->payment_method === 'deema') {
            try {
                CourseRegistrationController::applyDeemaStatus($registration, $deema->order($registration->invoice_id));
            } catch (\Throwable $e) {
                return back()->with('error', 'تعذّر الاتصال بـ deema: ' . $e->getMessage());
            }

            return back()->with('ok', 'حالة الدفع الآن: ' . $this->statusLabel($registration->fresh()->status));
        }

        try {
            $status = $myFatoorah->getPaymentStatus($registration->invoice_id, 'InvoiceId');
        } catch (\Throwable $e) {
            return back()->with('error', 'تعذّر الاتصال بماي فاتورة: ' . $e->getMessage());
        }

        CourseRegistrationController::applyStatus($registration, $status);

        return back()->with('ok', 'حالة الدفع الآن: ' . $this->statusLabel($registration->fresh()->status));
    }

    /** Re-sends a paid registration to the center's internal system (after fixing the course code, say). */
    public function sendToCenter(CourseRegistration $registration, CenterSystem $center)
    {
        if (!$center->enabled()) {
            return back()->with('error', 'الربط مع نظام المركز مش مفعّل (CENTER_SYSTEM_URL / CENTER_SYSTEM_TOKEN)');
        }

        return $center->push($registration)
            ? back()->with('ok', "انبعت {$registration->name} لنظام المركز — ملف #{$registration->center_patient_id}")
            : back()->with('error', 'ما انبعت: ' . $registration->center_error);
    }

    public function exportRegistrations()
    {
        $registrations = CourseRegistration::latest()->get();

        $response = new StreamedResponse(function () use ($registrations) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM
            fputcsv($handle, ['#', 'الدورة', 'الاسم', 'الهاتف', 'الإيميل', 'كود الخصم', 'السعر', 'الخصم', 'المدفوع', 'الحالة', 'رقم الفاتورة', 'طريقة الدفع', 'كود الهدية', 'حالة كود الهدية', 'المصدر', 'الحملة', 'تاريخ الدفع', 'تاريخ التسجيل']);
            foreach ($registrations as $r) {
                fputcsv($handle, [
                    $r->id,
                    $r->offer()['title']['ar'] ?? $r->course_key,
                    $r->name,
                    $r->phone,
                    $r->email,
                    $r->discount_code,
                    $r->original_amount,
                    $r->discount_amount,
                    $r->final_amount,
                    $this->statusLabel($r->status),
                    $r->invoice_id,
                    $r->payment_method,
                    $r->rewardCode()?->code,
                    $r->rewardCode() ? ($r->rewardCode()->used_count ? 'مستخدم' : 'غير مستخدم') : '',
                    $r->sourceLabel(),
                    $r->utm_campaign,
                    $r->paid_at?->format('Y-m-d H:i'),
                    $r->created_at->format('Y-m-d H:i'),
                ]);
            }
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="registrations-' . now()->format('Y-m-d') . '.csv"');
        return $response;
    }

    // ─── Discount codes ───

    public function codes()
    {
        return view('admin.discount-codes', [
            'codes'  => DiscountCode::whereNull('owner_registration_id')->latest()->get(), // referral codes live on the dashboard
            'offers' => CourseOffer::orderByDesc('date')->get()->mapWithKeys(fn ($o) => [$o->slug => $o->toOfferArray()])->all(),
        ]);
    }

    public function storeCode(Request $request)
    {
        $request->merge(['code' => strtoupper(trim((string) $request->code))]);

        $data = $request->validate([
            'code'       => ['required', 'alpha_dash', 'max:40', Rule::unique('discount_codes', 'code')],
            'type'       => 'required|in:percent,fixed',
            'value'      => ['required', 'numeric', 'gt:0', $request->type === 'percent' ? 'max:100' : 'max:100000'],
            'course_key' => ['nullable', Rule::in(CourseOffer::pluck('slug')->all())],
            'max_uses'   => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
        ], [
            'code.unique'     => 'هذا الكود موجود مسبقاً',
            'code.alpha_dash' => 'الكود يجب أن يحتوي على حروف إنجليزية وأرقام فقط',
            'value.max'       => 'نسبة الخصم لا يمكن أن تتجاوز 100%',
        ]);

        DiscountCode::create($data);

        return back()->with('ok', "تم إنشاء الكود {$data['code']}");
    }

    public function toggleCode(DiscountCode $code)
    {
        $code->update(['is_active' => !$code->is_active]);

        return back()->with('ok', $code->is_active ? "تم تفعيل {$code->code}" : "تم إيقاف {$code->code}");
    }

    public function destroyCode(DiscountCode $code)
    {
        $code->delete();

        return back()->with('ok', "تم حذف {$code->code}");
    }

    private function statusLabel(string $status): string
    {
        return ['paid' => 'مدفوع', 'pending' => 'بانتظار الدفع', 'failed' => 'فشل / ملغي'][$status] ?? $status;
    }
}
