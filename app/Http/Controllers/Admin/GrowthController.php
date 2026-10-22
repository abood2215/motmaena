<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseOffer;
use App\Models\CourseRegistration;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

/** "Notify me" sign-ups and post-course review requests. */
class GrowthController extends Controller
{
    public function leads(Request $request)
    {
        $leads = Lead::latest('updated_at')
            ->when($request->filter === 'new', fn ($q) => $q->whereNull('contacted_at'))
            ->get();

        return view('admin.leads', [
            'leads'    => $leads,
            'newCount' => Lead::whereNull('contacted_at')->count(),
            'courses'  => CourseOffer::upcoming(),
            'titles'   => CourseOffer::pluck('title_ar', 'slug'),
        ]);
    }

    public function markLeadContacted(Lead $lead)
    {
        $lead->update(['contacted_at' => $lead->contacted_at ? null : now()]);

        return back();
    }

    public function destroyLead(Lead $lead)
    {
        $lead->delete();

        return back()->with('ok', 'تم حذف الرقم');
    }

    public function exportLeads()
    {
        $leads = Lead::latest()->get();
        $titles = CourseOffer::pluck('title_ar', 'slug');

        $response = new StreamedResponse(function () use ($leads, $titles) {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($out, ['الرقم', 'الاسم', 'مهتم بـ', 'المصدر', 'تاريخ التسجيل', 'تم التواصل']);
            foreach ($leads as $l) {
                fputcsv($out, [$l->phone, $l->name, $titles[$l->course_key] ?? '', $l->utm_source ?: $l->referrer, $l->created_at->format('Y-m-d'), $l->contacted_at?->format('Y-m-d')]);
            }
            fclose($out);
        });
        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="leads-' . now()->format('Y-m-d') . '.csv"');

        return $response;
    }

    public function courseReviews(CourseOffer $offer)
    {
        $registrations = CourseRegistration::where('course_key', $offer->slug)->where('status', 'paid')
            ->with('testimonial')->orderBy('name')->get()
            ->unique('phone')->values();

        // Older paid registrations (before review links existed) get a token now
        $registrations->whereNull('review_token')->each(fn ($r) => $r->update(['review_token' => Str::random(32)]));

        return view('admin.course-reviews', compact('offer', 'registrations'));
    }

    public function markReviewRequested(CourseRegistration $registration)
    {
        $registration->update(['review_requested_at' => now()]);

        return response()->json(['ok' => true]);
    }
}
