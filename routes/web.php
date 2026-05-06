<?php

use Illuminate\Support\Facades\Route;

/* ================= CONTROLLERS ================= */
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\AdminStatisticsController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoadmapController;
use App\Http\Controllers\SelfAssessmentController;
use App\Http\Controllers\MentorDashboardController;
use App\Http\Controllers\SesiJadwalController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\MenteeSayaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return view('welcome');
});

/* ============================================================
   PUBLIC ROUTES (GUEST ONLY)
============================================================ */
Route::middleware('guest')->group(function () {

    // AUTH
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // PASSWORD RESET
    Route::get('/forgot-password',  [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendOtp'])->name('password.send-otp');

    Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('password.reset');

    Route::get('/reset-password-otp',  [AuthController::class, 'showOtpReset'])->name('password.otp.show');
    Route::post('/reset-password-otp', [AuthController::class, 'resetWithOtp'])->name('password.otp.reset');
});

/* ============================================================
   PROTECTED ROUTES (AUTH REQUIRED)
============================================================ */
Route::middleware('auth')->group(function () {

    /* ---------- Dashboard ---------- */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /* ---------- Profile ---------- */
    Route::get('/profile',       [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile',      [ProfileController::class, 'update'])->name('profile.update');

    /* ---------- CV MANAGEMENT ---------- */

    // halaman list CV
    Route::view('/manajemen-cv', 'jobseeker.manajemen-cv')->name('manajemen-cv.index');

    // halaman buat CV ATS
    Route::get('/buat-cv-ats', [CvController::class, 'create'])->name('buat-cv-ats.index');

    // generate CV
    Route::post('/cv', [GenerateController::class, 'store'])->name('cv.store');

    // download CV
    Route::get('/cv/{id}/download', [DownloadController::class, 'downloadPdf'])->name('cv.download');

    // resource CV TANPA create (biar ga conflict)
    Route::resource('cv', CvController::class)->except(['create']);

    // CV presentasi
    Route::view('/buat-cv-presentasi', 'jobseeker.buat-cv-presentasi')->name('buat-cv-presentasi.index');


    /* ---------- ROADMAP KARIER ---------- */
    Route::get('/roadmap-karier', [RoadmapController::class, 'index'])->name('roadmap-karier');
    Route::post('/roadmap-karier', [RoadmapController::class, 'store'])->name('roadmap-karier.store');
    Route::patch('/roadmap-karier/{id}', [RoadmapController::class, 'update'])->name('roadmap-karier.update');


    /* ---------- SELF ASSESSMENT ---------- */
    Route::get('/self-assessment',   [SelfAssessmentController::class, 'index'])->name('self-assessment');
    Route::post('/self-assessment',  [SelfAssessmentController::class, 'store'])->name('assessment.store');
    Route::get('/assessment/result', [SelfAssessmentController::class, 'result'])->name('assessment.result');


    /* ---------- STATIC PAGES ---------- */
    Route::view('/pelatihan', 'jobseeker.skill-training')->name('pelatihan.index');
    Route::view('/skill-training', 'jobseeker.skill-training')->name('skill-training.index');
    Route::view('/forum', 'forum.index')->name('forum.index');

    // Notifikasi
    Route::get('/notifikasi', [NotificationController::class, 'index']);
    Route::view('/notifikasi', 'notifikasi.index')->name('notifikasi.index');
    Route::post('/notifikasi/read-all', [NotifikasiController::class, 'readAll'])
    ->name('notifikasi.read-all');

    // Mentorship
    Route::view('/mentorship', 'jobseeker.mentorship')->name('mentorship.index');


    /* ---------- AUTH ACTION ---------- */
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

        // availability
        Route::post('/availability',        [MentorDashboardController::class, 'storeAvailability'])->name('availability.store');
        Route::put('/availability/{id}',    [MentorDashboardController::class, 'updateAvailability'])->name('availability.update');
        Route::delete('/availability/{id}', [MentorDashboardController::class, 'destroyAvailability'])->name('availability.destroy');

        // booking
        Route::post('/bookings/{id}/accept', [MentorDashboardController::class, 'acceptBooking'])->name('bookings.accept');
        Route::post('/bookings/{id}/reject', [MentorDashboardController::class, 'rejectBooking'])->name('bookings.reject');
    });

});
