<?php

use Illuminate\Support\Facades\Route;
use App\Models\Course;
use App\Http\Controllers\ConsultationController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

Route::get('/course/{course}', function (Course $course) {
    return view('course-details', compact('course'));
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
