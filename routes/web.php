<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\AdminStatisticsController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoadmapController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MentorDashboardController;
use App\Http\Controllers\SesiJadwalController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\MenteeSayaController;

Route::get('/', function () {
    return view('welcome');
});

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
    // Dashboard (role-aware redirect is handled in controller)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // CV Management
    Route::get('/manajemen-cv', [CvController::class, 'index'])->name('manajemen-cv.index');
    Route::get('/buat-cv-ats', [CvController::class, 'create'])->name('buat-cv-ats.index');
    Route::resource('cv', CvController::class);

    // Roadmap & Assessment
    Route::get('/roadmap-karier', [RoadmapController::class, 'index'])->name('roadmap-karier');
    Route::post('/roadmap-karier', [RoadmapController::class, 'store'])->name('roadmap-karier.store');
    Route::patch('/roadmap-karier/{id}', [RoadmapController::class, 'update'])->name('roadmap-karier.update');
    Route::view('/self-assessment', 'self-assessment.index')->name('self-assessment.index');

    // Pelatihan / Skill Training
    Route::redirect('/pelatihan', '/skill-training')->name('pelatihan.index');
    Route::view('/skill-training', 'jobseeker.skill-training')->name('skill-training.index');

    // Forum
    Route::view('/forum', 'forum.index')->name('forum.index');

    // Notifikasi
    Route::view('/notifikasi', 'notifikasi.index')->name('notifikasi.index');

    // Mentorship
    Route::view('/mentorship', 'jobseeker.mentorship')->name('mentorship.index');
    Route::get('/riwayat-feedback', [\App\Http\Controllers\JobseekerFeedbackController::class, 'index'])->name('jobseeker.feedback.index');

    // Auth Actions
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/me', [AuthController::class, 'me'])->name('auth.me');

    // ---- Admin Routes ----
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/statistics', [AdminStatisticsController::class, 'show'])->name('admin.statistics');
        Route::get('/admin/users', [AdminStatisticsController::class, 'users'])->name('admin.users');
        Route::get('/admin/activity', [AdminStatisticsController::class, 'activity'])->name('admin.activity');
    });

    // ---- Mentor Routes ----
    Route::prefix('mentor')->group(function () {
        Route::get('/dashboard', [MentorDashboardController::class, 'index'])->name('mentor.dashboard');
        Route::view('/settings', 'mentor.settings')->name('mentor.settings');
        Route::resource('sesi-jadwal', SesiJadwalController::class)->names('mentor.sesi-jadwal');
        Route::post('sesi-jadwal/{id}/notes', [SesiJadwalController::class, 'addNotes'])->name('mentor.sesi-jadwal.notes');
        Route::resource('feedback', FeedbackController::class)->names('mentor.feedback');
        Route::get('/mentee', [MenteeSayaController::class, 'index'])->name('mentor.mentee.index');

        // Availability management
        Route::post('/availability', [MentorDashboardController::class, 'storeAvailability'])->name('mentor.availability.store');
        Route::put('/availability/{id}', [MentorDashboardController::class, 'updateAvailability'])->name('mentor.availability.update');
        Route::delete('/availability/{id}', [MentorDashboardController::class, 'destroyAvailability'])->name('mentor.availability.destroy');

        // Booking actions
        Route::post('/bookings/{id}/accept', [MentorDashboardController::class, 'acceptBooking'])->name('mentor.bookings.accept');
        Route::post('/bookings/{id}/reject', [MentorDashboardController::class, 'rejectBooking'])->name('mentor.bookings.reject');
    });
});
