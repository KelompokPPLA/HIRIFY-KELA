<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\AdminMentorManagementController;
use App\Http\Controllers\AdminStatisticsController;
use App\Http\Controllers\AdminTrainingModuleController;
use App\Http\Controllers\AdminUserManagementController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoadmapController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MentorDashboardController;
use App\Http\Controllers\SesiJadwalController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\MenteeSayaController;
use App\Http\Controllers\NotificationController;

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
    Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifikasi.index');
    Route::post('/notifikasi/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifikasi.read-all');
    Route::patch('/notifikasi/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifikasi.read');

    // Mentorship
    Route::view('/mentorship', 'jobseeker.mentorship')->name('mentorship.index');
    Route::get('/riwayat-feedback', [\App\Http\Controllers\JobseekerFeedbackController::class, 'index'])->name('jobseeker.feedback.index');

    // Auth Actions
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/me', [AuthController::class, 'me'])->name('auth.me');

    // ---- Admin Routes ----
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/statistics', [AdminStatisticsController::class, 'show'])->name('admin.statistics');
        Route::get('/admin/users', [AdminUserManagementController::class, 'index'])->name('admin.users');
        Route::get('/admin/users/create', [AdminUserManagementController::class, 'create'])->name('admin.users.create');
        Route::post('/admin/users', [AdminUserManagementController::class, 'store'])->name('admin.users.store');
        Route::get('/admin/users/{user}/edit', [AdminUserManagementController::class, 'edit'])->name('admin.users.edit');
        Route::patch('/admin/users/{user}', [AdminUserManagementController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [AdminUserManagementController::class, 'destroy'])->name('admin.users.destroy');
        Route::get('/admin/mentors', [AdminMentorManagementController::class, 'index'])->name('admin.mentors');
        Route::get('/admin/mentors/create', [AdminMentorManagementController::class, 'create'])->name('admin.mentors.create');
        Route::post('/admin/mentors', [AdminMentorManagementController::class, 'store'])->name('admin.mentors.store');
        Route::get('/admin/mentors/{mentor}/edit', [AdminMentorManagementController::class, 'edit'])->name('admin.mentors.edit');
        Route::patch('/admin/mentors/{mentor}', [AdminMentorManagementController::class, 'update'])->name('admin.mentors.update');
        Route::delete('/admin/mentors/{mentor}', [AdminMentorManagementController::class, 'destroy'])->name('admin.mentors.destroy');
        Route::get('/admin/training-modules', [AdminTrainingModuleController::class, 'index'])->name('admin.training-modules');
        Route::get('/admin/training-modules/create', [AdminTrainingModuleController::class, 'create'])->name('admin.training-modules.create');
        Route::post('/admin/training-modules', [AdminTrainingModuleController::class, 'store'])->name('admin.training-modules.store');
        Route::get('/admin/training-modules/{trainingModule}/edit', [AdminTrainingModuleController::class, 'edit'])->name('admin.training-modules.edit');
        Route::patch('/admin/training-modules/{trainingModule}', [AdminTrainingModuleController::class, 'update'])->name('admin.training-modules.update');
        Route::delete('/admin/training-modules/{trainingModule}', [AdminTrainingModuleController::class, 'destroy'])->name('admin.training-modules.destroy');
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
        Route::get('/mentee/{mentee}', [MenteeSayaController::class, 'show'])->name('mentor.mentee.show');

        // Availability management
        Route::post('/availability', [MentorDashboardController::class, 'storeAvailability'])->name('mentor.availability.store');
        Route::put('/availability/{id}', [MentorDashboardController::class, 'updateAvailability'])->name('mentor.availability.update');
        Route::delete('/availability/{id}', [MentorDashboardController::class, 'destroyAvailability'])->name('mentor.availability.destroy');

        // Booking actions
        Route::post('/bookings/{id}/accept', [MentorDashboardController::class, 'acceptBooking'])->name('mentor.bookings.accept');
        Route::post('/bookings/{id}/reject', [MentorDashboardController::class, 'rejectBooking'])->name('mentor.bookings.reject');
    });
});
