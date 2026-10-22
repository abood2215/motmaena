<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConsultationBooking;
use App\Models\CourseRegistration;

class DashboardController extends Controller
{
    public function index()
    {
        $paid = CourseRegistration::where('status', 'paid');
        $revenue = fn ($from) => (float) (clone $paid)->where('paid_at', '>=', $from)->sum('final_amount');

        $totalRegistrations = CourseRegistration::count();
        $paidCount = (clone $paid)->count();

        $stats = [
            'revenue_today' => $revenue(now()->startOfDay()),
            'revenue_7'     => $revenue(now()->subDays(6)->startOfDay()),
            'revenue_30'    => $revenue(now()->subDays(29)->startOfDay()),
            'revenue_all'   => (float) (clone $paid)->sum('final_amount'),
            'paid'          => $paidCount,
            'registrations' => $totalRegistrations,
            'conversion'    => $totalRegistrations ? round($paidCount / $totalRegistrations * 100) : 0,
            'follow_up'     => CourseRegistration::needsFollowUp()->get(['phone', 'course_key'])->unique(fn ($r) => $r->phone . '|' . $r->course_key)->count(),
            'consultations_new' => ConsultationBooking::where('status', 'pending')->count(),
        ];

        // Daily revenue, last 30 days (filled in PHP so it works on SQLite and MySQL alike)
        $byDay = (clone $paid)->where('paid_at', '>=', now()->subDays(29)->startOfDay())->get(['paid_at', 'final_amount'])
            ->groupBy(fn ($r) => $r->paid_at->format('Y-m-d'))
            ->map(fn ($rows) => round($rows->sum('final_amount'), 3));
        $chart = collect(range(29, 0))->mapWithKeys(function ($i) use ($byDay) {
            $day = now()->subDays($i)->format('Y-m-d');
            return [$day => $byDay[$day] ?? 0];
        });

        $paidRows = (clone $paid)->get();
        $sources = $paidRows->groupBy(fn ($r) => $r->sourceLabel())
            ->map(fn ($rows, $label) => ['label' => $label, 'count' => $rows->count(), 'revenue' => $rows->sum('final_amount')])
            ->sortByDesc('count')->values();
        $codes = $paidRows->whereNotNull('discount_code')->groupBy('discount_code')
            ->map(fn ($rows, $code) => ['code' => $code, 'count' => $rows->count(), 'discount' => $rows->sum('discount_amount')])
            ->sortByDesc('count')->values();
        $courses = $paidRows->groupBy('course_key')
            ->map(fn ($rows) => ['title' => $rows->first()->offer()['title']['ar'] ?? $rows->first()->course_key, 'count' => $rows->count(), 'revenue' => $rows->sum('final_amount')])
            ->sortByDesc('revenue')->values();

        $latest = CourseRegistration::where('status', 'paid')->latest('paid_at')->take(6)->get();

        return view('admin.dashboard', compact('stats', 'chart', 'sources', 'codes', 'courses', 'latest'));
    }
}
