<?php

use Illuminate\Support\Facades\Route;
use App\Models\Course;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\CourseRegistrationController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\CourseAdminController;
use App\Http\Controllers\Admin\CourseOfferController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GrowthController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ReviewController;
use App\Http\Middleware\AdminAuth;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

// The details page only had placeholder data (price, lessons) and a dead button;
// send visitors to where the course is actually sold.
Route::get('/course/{course}', function (Course $course) {
    return $course->external_url ? redirect()->away($course->external_url) : redirect()->route('courses');
})->name('course.show');
Route::get('/sessions', function () {
    return view('sessions');
})->name('sessions');
Route::get('/courses', function () {
    return view('courses');
})->name('courses');
Route::get('/packages', function () {
    return view('packages');
})->name('packages');
Route::get('/consultations', function () {
    return view('consultations');
})->name('consultations');

Route::view('/policies', 'policies')->name('policies');
Route::redirect('/terms', '/policies#terms');
Route::redirect('/privacy', '/policies#privacy');
Route::redirect('/refund-policy', '/policies#refund');

Route::get('/sitemap.xml', function () {
    $urls = collect(['home', 'courses', 'packages', 'sessions', 'consultations', 'policies'])->map(fn ($r) => route($r))
        ->merge(\App\Models\CourseOffer::where('is_active', true)->pluck('slug')->map(fn ($k) => route('course.register', $k)));

    return response()->view('sitemap', ['urls' => $urls])->header('Content-Type', 'application/xml');
})->name('sitemap');

Route::post('/consultations/book', [ConsultationController::class, 'store'])->name('consultations.book');
Route::get('/admin/consultations', [ConsultationController::class, 'admin'])->name('admin.consultations');
Route::post('/admin/login', [ConsultationController::class, 'adminLogin'])->middleware('throttle:5,1')->name('admin.login');
Route::get('/admin/logout', [ConsultationController::class, 'adminLogout'])->name('admin.logout');
Route::post('/admin/consultations/{booking}/status', [ConsultationController::class, 'updateStatus'])->name('admin.consultations.status');
Route::post('/admin/consultations/{booking}/notes', [ConsultationController::class, 'updateNotes'])->name('admin.consultations.notes');
Route::get('/admin/consultations/export', [ConsultationController::class, 'exportCsv'])->name('admin.consultations.export');
Route::get('/admin/consultations/new-count', [ConsultationController::class, 'newCount'])->name('admin.consultations.new-count');

// Course registration + MyFatoorah payment
Route::get('/register/{offer}', [CourseRegistrationController::class, 'show'])->name('course.register');
Route::post('/register/{offer}/check-code', [CourseRegistrationController::class, 'checkCode'])
    ->middleware('throttle:15,1')->name('course.register.check-code');
Route::post('/register/{offer}', [CourseRegistrationController::class, 'store'])
    ->middleware('throttle:10,1')->name('course.register.store');
Route::post('/notify', [LeadController::class, 'store'])->middleware('throttle:6,1')->name('leads.store');
Route::get('/review/{token}', [ReviewController::class, 'show'])->name('review.show');
Route::post('/review/{token}', [ReviewController::class, 'store'])->middleware('throttle:6,1')->name('review.store');

Route::get('/payment/callback', [CourseRegistrationController::class, 'callback'])->name('payment.callback');

Route::middleware(AdminAuth::class)->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/courses', [CourseOfferController::class, 'index'])->name('courses');
    Route::get('/courses/create', [CourseOfferController::class, 'create'])->name('courses.create');
    Route::post('/courses', [CourseOfferController::class, 'store'])->name('courses.store');
    Route::get('/courses/{offer}/edit', [CourseOfferController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{offer}', [CourseOfferController::class, 'update'])->name('courses.update');
    Route::post('/courses/{offer}/toggle/{field}', [CourseOfferController::class, 'toggle'])->name('courses.toggle');
    Route::delete('/courses/{offer}', [CourseOfferController::class, 'destroy'])->name('courses.destroy');

    Route::get('/content', [ContentController::class, 'index'])->name('content');
    Route::post('/content/settings', [ContentController::class, 'updateSettings'])->name('content.settings');
    Route::post('/content/faqs', [ContentController::class, 'storeFaq'])->name('content.faqs.store');
    Route::put('/content/faqs/{faq}', [ContentController::class, 'updateFaq'])->name('content.faqs.update');
    Route::delete('/content/faqs/{faq}', [ContentController::class, 'destroyFaq'])->name('content.faqs.destroy');
    Route::post('/content/testimonials', [ContentController::class, 'storeTestimonial'])->name('content.testimonials.store');
    Route::put('/content/testimonials/{testimonial}', [ContentController::class, 'updateTestimonial'])->name('content.testimonials.update');
    Route::delete('/content/testimonials/{testimonial}', [ContentController::class, 'destroyTestimonial'])->name('content.testimonials.destroy');

    Route::get('/courses/{offer}/reviews', [GrowthController::class, 'courseReviews'])->name('courses.reviews');
    Route::post('/registrations/{registration}/review-requested', [GrowthController::class, 'markReviewRequested'])->name('registrations.review-requested');

    Route::get('/leads', [GrowthController::class, 'leads'])->name('leads');
    Route::get('/leads/export', [GrowthController::class, 'exportLeads'])->name('leads.export');
    Route::post('/leads/{lead}/contacted', [GrowthController::class, 'markLeadContacted'])->name('leads.contacted');
    Route::delete('/leads/{lead}', [GrowthController::class, 'destroyLead'])->name('leads.destroy');

    Route::get('/registrations', [CourseAdminController::class, 'registrations'])->name('registrations');
    Route::post('/registrations/{registration}/followed', [CourseAdminController::class, 'markFollowedUp'])->name('registrations.followed');
    Route::get('/registrations/export', [CourseAdminController::class, 'exportRegistrations'])->name('registrations.export');
    Route::post('/registrations/{registration}/verify', [CourseAdminController::class, 'verify'])->name('registrations.verify');

    Route::get('/discount-codes', [CourseAdminController::class, 'codes'])->name('codes');
    Route::post('/discount-codes', [CourseAdminController::class, 'storeCode'])->name('codes.store');
    Route::post('/discount-codes/{code}/toggle', [CourseAdminController::class, 'toggleCode'])->name('codes.toggle');
    Route::delete('/discount-codes/{code}', [CourseAdminController::class, 'destroyCode'])->name('codes.destroy');
});
