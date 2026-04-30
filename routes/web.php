<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MentorDashboardController;
use App\Http\Controllers\SesiJadwalController;
use App\Http\Controllers\FeedbackController;

Route::get('/', fn() => redirect()->route('dashboard'));

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');
Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');
Route::view('/reset-password', 'auth.reset-password')->name('password.reset');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/profile', fn() => view('profile.index'))->name('profile');
Route::get('/manajemen-cv', fn() => view('manajemen-cv.index'))->name('manajemen-cv');
Route::get('/buat-cv-ats', fn() => view('buat-cv-ats.index'))->name('buat-cv-ats');
Route::get('/roadmap-karier', fn() => view('roadmap-karier.index'))->name('roadmap-karier');
Route::get('/self-assessment', fn() => view('self-assessment.index'))->name('self-assessment');
Route::get('/pelatihan', fn() => view('pelatihan.index'))->name('pelatihan');
Route::get('/notifikasi', fn() => view('notifikasi.index'))->name('notifikasi');

Route::view('/mentor/settings', 'mentor.settings')->name('mentor.settings');
Route::view('/mentorship', 'jobseeker.mentorship')->name('mentorship.index');
Route::view('/forum', 'forum.index')->name('forum.index');
Route::view('/skill-training', 'jobseeker.skill-training')->name('skill.training');
Route::view('/admin/statistics', 'admin.statistics')->name('admin.statistics');

// Route for mentor session listing handled inside mentor group below

Route::prefix('mentor')->name('mentor.')->group(function () {

    Route::get('/dashboard', [MentorDashboardController::class, 'index'])->name('dashboard');

    Route::controller(MentorDashboardController::class)->group(function () {
        Route::post('/availability', 'storeAvailability')->name('availability.store');
        Route::put('/availability/{availability}', 'updateAvailability')->name('availability.update');
        Route::delete('/availability/{availability}', 'destroyAvailability')->name('availability.destroy');

        Route::post('/bookings/{booking}/accept', 'acceptBooking')->name('bookings.accept');
        Route::post('/bookings/{booking}/reject', 'rejectBooking')->name('bookings.reject');
    });

    Route::prefix('sesi-jadwal')->name('sesi-jadwal.')->group(function () {
        Route::get('/', [SesiJadwalController::class, 'index'])->name('index');
        Route::get('/create', [SesiJadwalController::class, 'create'])->name('create');
        Route::post('/', [SesiJadwalController::class, 'store'])->name('store');

        Route::get('/{session}/edit', [SesiJadwalController::class, 'edit'])->name('edit');
        Route::get('/{session}', [SesiJadwalController::class, 'show'])->name('show');

        Route::put('/{session}', [SesiJadwalController::class, 'update'])->name('update');
        Route::delete('/{session}', [SesiJadwalController::class, 'destroy'])->name('destroy');

        Route::post('/{session}/notes', [SesiJadwalController::class, 'addNotes'])->name('notes');
    });

    Route::prefix('feedback')->name('feedback.')->group(function () {
        Route::get('/', [FeedbackController::class, 'index'])->name('index');
        Route::post('/', [FeedbackController::class, 'store'])->name('store');
    });

});
