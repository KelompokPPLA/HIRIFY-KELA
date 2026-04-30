<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');
Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');
Route::view('/reset-password', 'auth.reset-password')->name('password.reset');
Route::view('/dashboard', 'auth.dashboard')->name('dashboard');
Route::view('/mentor/settings', 'mentor.settings')->name('mentor.settings');
Route::view('/mentorship', 'jobseeker.mentorship')->name('mentorship.index');

Route::middleware(['auth', 'role:mentor'])->group(function () {
    // Mentor Dashboard
    Route::get('/mentor/dashboard', [MentorDashboardController::class, 'index'])->name('mentor.dashboard');
    Route::post('/mentor/availability', [MentorDashboardController::class, 'storeAvailability'])->name('mentor.availability.store');
    Route::put('/mentor/availability/{id}', [MentorDashboardController::class, 'updateAvailability'])->name('mentor.availability.update');
    Route::delete('/mentor/availability/{id}', [MentorDashboardController::class, 'destroyAvailability'])->name('mentor.availability.destroy');
    Route::post('/mentor/bookings/{id}/accept', [MentorDashboardController::class, 'acceptBooking'])->name('mentor.bookings.accept');
    Route::post('/mentor/bookings/{id}/reject', [MentorDashboardController::class, 'rejectBooking'])->name('mentor.bookings.reject');