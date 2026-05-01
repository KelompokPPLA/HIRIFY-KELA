<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\AdminStatisticsController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\ProfileController;
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
    Route::post('/forgot-password', [AuthController::class, 'sendOtp'])->name('password.send-otp');
    Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('password.reset');

    // OTP Reset Flow
    Route::get('/reset-password-otp', [AuthController::class, 'showOtpReset'])->name('password.otp.show');
    Route::post('/reset-password-otp', [AuthController::class, 'resetWithOtp'])->name('password.otp.reset');
});

// ============= PROTECTED ROUTES (Auth Required) =============
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // CV Management
    Route::get('/manajemen-cv', [CvController::class, 'index'])->name('manajemen-cv.index');
    Route::get('/buat-cv-ats', [CvController::class, 'create'])->name('buat-cv-ats.index');
    Route::resource('cv', CvController::class);

    // Roadmap & Assessment
    Route::view('/roadmap-karier', 'roadmap-karier.index')->name('roadmap-karier.index');
    Route::view('/self-assessment', 'self-assessment.index')->name('self-assessment.index');

    // Pelatihan / Skill Training (redirect pelatihan → skill-training)
    Route::redirect('/pelatihan', '/skill-training')->name('pelatihan.index');
    Route::view('/skill-training', 'jobseeker.skill-training')->name('skill-training.index');

    // Forum
    Route::view('/forum', 'forum.index')->name('forum.index');

    // Notifikasi
    Route::view('/notifikasi', 'notifikasi.index')->name('notifikasi.index');

    // Admin
    Route::get('/admin/statistics', [AdminStatisticsController::class, 'show'])->name('admin.statistics');
    Route::get('/admin/users', [AdminStatisticsController::class, 'users'])->name('admin.users');
    Route::get('/admin/activity', [AdminStatisticsController::class, 'activity'])->name('admin.activity');

    // Mentor
    Route::view('/mentor/settings', 'mentor.settings')->name('mentor.settings');

    // Mentorship
    Route::view('/mentorship', 'jobseeker.mentorship')->name('mentorship.index');

    // Auth Actions
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/me', [AuthController::class, 'me'])->name('auth.me');
});
