<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CourseRegistrationController;
use App\Models\CourseRegistration;
use App\Models\DiscountCode;
use App\Services\MyFatoorah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CourseAdminController extends Controller
{
    // ─── Registrations ───

    public function registrations(Request $request)
    {
        $registrations = CourseRegistration::latest()
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->get();

        $all = CourseRegistration::query();
        $stats = [
            'total'   => (clone $all)->count(),
            'paid'    => (clone $all)->where('status', 'paid')->count(),
            'pending' => (clone $all)->where('status', 'pending')->count(),
            'revenue' => (float) (clone $all)->where('status', 'paid')->sum('final_amount'),
        ];

        return view('admin.registrations', compact('registrations', 'stats'));
    }

    public function verify(CourseRegistration $registration, MyFatoorah $myFatoorah)
    {
        if (!$registration->invoice_id) {
            return back()->with('error', 'لا يوجد رقم فاتورة لهذا التسجيل');
        }

        try {
            $status = $myFatoorah->getPaymentStatus($registration->invoice_id, 'InvoiceId');
        } catch (\Throwable $e) {
            return back()->with('error', 'تعذّر الاتصال بماي فاتورة: ' . $e->getMessage());
        }

        CourseRegistrationController::applyStatus($registration, $status);

        return back()->with('ok', 'حالة الدفع الآن: ' . $this->statusLabel($registration->fresh()->status));
    }

    public function exportRegistrations()
    {
        $registrations = CourseRegistration::latest()->get();

        $response = new StreamedResponse(function () use ($registrations) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM
            fputcsv($handle, ['#', 'الدورة', 'الاسم', 'الهاتف', 'الإيميل', 'كود الخصم', 'السعر', 'الخصم', 'المدفوع', 'الحالة', 'رقم الفاتورة', 'طريقة الدفع', 'تاريخ الدفع', 'تاريخ التسجيل']);
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
            'codes'  => DiscountCode::latest()->get(),
            'offers' => config('course_offers'),
        ]);
    }

    public function storeCode(Request $request)
    {
        $request->merge(['code' => strtoupper(trim((string) $request->code))]);

        $data = $request->validate([
            'code'       => ['required', 'alpha_dash', 'max:40', Rule::unique('discount_codes', 'code')],
            'type'       => 'required|in:percent,fixed',
            'value'      => ['required', 'numeric', 'gt:0', $request->type === 'percent' ? 'max:100' : 'max:100000'],
            'course_key' => ['nullable', Rule::in(array_keys(config('course_offers')))],
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
