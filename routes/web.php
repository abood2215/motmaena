<?php

use Illuminate\Support\Facades\Route;
use App\Models\Course;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\CourseRegistrationController;
use App\Http\Controllers\Admin\CourseAdminController;
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

Route::post('/consultations/book', [ConsultationController::class, 'store'])->name('consultations.book');
Route::get('/admin/consultations', [ConsultationController::class, 'admin'])->name('admin.consultations');
Route::post('/admin/login', [ConsultationController::class, 'adminLogin'])->name('admin.login');
Route::get('/admin/logout', [ConsultationController::class, 'adminLogout'])->name('admin.logout');
Route::post('/admin/consultations/{booking}/status', [ConsultationController::class, 'updateStatus'])->name('admin.consultations.status');
Route::post('/admin/consultations/{booking}/notes', [ConsultationController::class, 'updateNotes'])->name('admin.consultations.notes');
Route::get('/admin/consultations/export', [ConsultationController::class, 'exportCsv'])->name('admin.consultations.export');
Route::get('/admin/consultations/new-count', [ConsultationController::class, 'newCount'])->name('admin.consultations.new-count');
Route::get('/admin/diag', [ConsultationController::class, 'diag']);

// Course registration + MyFatoorah payment
Route::get('/register/{offer}', [CourseRegistrationController::class, 'show'])->name('course.register');
Route::post('/register/{offer}/check-code', [CourseRegistrationController::class, 'checkCode'])
    ->middleware('throttle:15,1')->name('course.register.check-code');
Route::post('/register/{offer}', [CourseRegistrationController::class, 'store'])
    ->middleware('throttle:10,1')->name('course.register.store');
Route::get('/payment/callback', [CourseRegistrationController::class, 'callback'])->name('payment.callback');

Route::middleware(AdminAuth::class)->prefix('admin')->name('admin.')->group(function () {
    Route::get('/registrations', [CourseAdminController::class, 'registrations'])->name('registrations');
    Route::get('/registrations/export', [CourseAdminController::class, 'exportRegistrations'])->name('registrations.export');
    Route::post('/registrations/{registration}/verify', [CourseAdminController::class, 'verify'])->name('registrations.verify');

    Route::get('/discount-codes', [CourseAdminController::class, 'codes'])->name('codes');
    Route::post('/discount-codes', [CourseAdminController::class, 'storeCode'])->name('codes.store');
    Route::post('/discount-codes/{code}/toggle', [CourseAdminController::class, 'toggleCode'])->name('codes.toggle');
    Route::delete('/discount-codes/{code}', [CourseAdminController::class, 'destroyCode'])->name('codes.destroy');
});
