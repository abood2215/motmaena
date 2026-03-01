<?php

use Illuminate\Support\Facades\Route;

use App\Models\Course;

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
