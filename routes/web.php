<?php

use App\Http\Controllers\CvController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Public routes
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');
Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');
Route::view('/reset-password', 'auth.reset-password')->name('password.reset');
Route::view('/dashboard', 'auth.dashboard')->name('dashboard');
Route::view('/mentor/settings', 'mentor.settings')->name('mentor.settings');
Route::view('/mentorship', 'jobseeker.mentorship')->name('mentorship.index');

// CV Routes - WAJIB menggunakan middleware auth
Route::middleware(['auth'])->group(function () {
    Route::resource('cv', CvController::class);
});
