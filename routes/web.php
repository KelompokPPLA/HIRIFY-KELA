<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\CvController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MentorDashboardController;
use App\Http\Controllers\SesiJadwalController;
use App\Http\Controllers\FeedbackController;

Route::get('/', fn() => redirect()->route('dashboard'));

// ============= PUBLIC AUTH ROUTES (No Auth Required) =============
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Password Reset
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('password.reset');
});

// ============= PROTECTED ROUTES (Auth Required) =============
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('auth.dashboard');
    })->name('dashboard');

    // CV Management — PBI 6: Generate CV ATS
    Route::resource('buat-cv-ats', CvController::class);

    // Roadmap Karier — PBI 4 (placeholder)
    Route::get('/roadmap', function () {
        return view('roadmap-karier.index');
    })->name('roadmap.index');

    // Self Assessment — PBI 5 (placeholder)
    Route::get('/assessment', function () {
        return view('self-assessment.index');
    })->name('assessment.index');

    // Mentor
    Route::view('/mentor/settings', 'mentor.settings')->name('mentor.settings');

    // Mentorship
    Route::view('/mentorship', 'jobseeker.mentorship')->name('mentorship.index');

    // Auth Actions
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/me', [AuthController::class, 'me'])->name('auth.me');
});