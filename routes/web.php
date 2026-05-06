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
use App\Http\Controllers\GenerateController;
use App\Http\Controllers\DownloadController;

/* ============================================================
   WELCOME
============================================================ */
Route::get('/', function () {
    return view('welcome');
});

/* ============================================================
   PUBLIC ROUTES (guests only)
============================================================ */
Route::middleware('guest')->group(function () {

    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/forgot-password',  [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendOtp'])->name('password.send-otp');

    Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('password.reset');

    Route::get('/reset-password-otp',  [AuthController::class, 'showOtpReset'])->name('password.otp.show');
    Route::post('/reset-password-otp', [AuthController::class, 'resetWithOtp'])->name('password.otp.reset');
});

/* ============================================================
   PROTECTED ROUTES (auth required)
============================================================ */
Route::middleware('auth')->group(function () {

    /* ---------- Dashboard ---------- */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /* ---------- Profile ---------- */
    Route::get('/profile',       [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile',      [ProfileController::class, 'update'])->name('profile.update');

    /* ---------- CV Management ----------
     *
     * FIX: Route::resource('cv', CvController::class) was defined AFTER an
     * explicit Route::get('/buat-cv-ats', ...) that also maps to
     * CvController@create. This caused a duplicate-action conflict and the
     * named route 'buat-cv-ats.index' (used throughout blade templates)
     * could be shadowed by the resource's 'cv.create' route.
     *
     * Resolution:
     *  - Keep the explicit named route for the ATS creation view so blade
     *    templates continue to use route('buat-cv-ats.index') without change.
     *  - Exclude 'create' from the resource so there is only ONE route that
     *    points to CvController@create (/buat-cv-ats).
     *  - The resource still provides: index, store, show, edit, update, destroy.
     */
    Route::get('/manajemen-cv', function () {
        return view('jobseeker.manajemen-cv');
    })->name('manajemen-cv.index');

    // Explicit ATS creation page (keeps the 'buat-cv-ats.index' name used in blades)
    Route::get('/buat-cv-ats', [CvController::class, 'create'])->name('buat-cv-ats.index');

    // Resource routes — 'create' excluded to avoid conflict with the route above
    Route::resource('cv', CvController::class)->except(['create']);

    Route::view('/buat-cv-presentasi', 'jobseeker.buat-cv-presentasi')->name('buat-cv-presentasi.index');
    Route::get('/cv/{id}/download', [DownloadController::class, 'downloadPdf']);
    Route::post('/cv', [GenerateController::class, 'store'])->name('cv.store');

    /* ---------- Roadmap & Assessment ---------- */
    Route::view('/roadmap-karier',  'roadmap-karier.index')->name('roadmap-karier.index');
    Route::view('/self-assessment', 'self-assessment.index')->name('self-assessment.index');

    /* ---------- Skill Training ---------- */
    // FIX: redirect('/pelatihan', '/skill-training') is a permanent (301) redirect
    // by default. Using ->redirect() with status 302 is safer to avoid browsers
    // caching a redirect that might change.
    Route::redirect('/pelatihan', '/skill-training', 302)->name('pelatihan.index');
    Route::view('/skill-training', 'jobseeker.skill-training')->name('skill-training.index');

    /* ---------- Forum ---------- */
    Route::view('/forum', 'forum.index')->name('forum.index');

    /* ---------- Notifikasi ---------- */
    Route::view('/notifikasi', 'notifikasi.index')->name('notifikasi.index');

    /* ---------- Mentorship ---------- */
    Route::view('/mentorship', 'jobseeker.mentorship')->name('mentorship.index');

    Route::get('/riwayat-feedback', [\App\Http\Controllers\JobseekerFeedbackController::class, 'index'])
         ->name('jobseeker.feedback.index');

    /* ---------- Auth Actions ---------- */
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/me',      [AuthController::class, 'me'])->name('auth.me');

    /* ==========================================================
       ADMIN ROUTES
    ========================================================== */
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/statistics', [AdminStatisticsController::class, 'show'])->name('admin.statistics');
        Route::get('/users',      [AdminStatisticsController::class, 'users'])->name('admin.users');
        Route::get('/activity',   [AdminStatisticsController::class, 'activity'])->name('admin.activity');
    });

    /* ==========================================================
       MENTOR ROUTES
    ========================================================== */
    Route::prefix('mentor')->name('mentor.')->group(function () {

        Route::get('/dashboard', [MentorDashboardController::class, 'index'])->name('dashboard');
        Route::view('/settings', 'mentor.settings')->name('settings');
        Route::get('/mentee', [\App\Http\Controllers\MenteeSayaController::class, 'index'])->name('mentee.index');
        Route::get('/mentee/{id}', [\App\Http\Controllers\MenteeSayaController::class, 'show'])->name('mentee.show');

        // Sesi & jadwal
        Route::resource('sesi-jadwal', SesiJadwalController::class)->names('sesi-jadwal');
        Route::post('sesi-jadwal/{id}/notes', [SesiJadwalController::class, 'addNotes'])->name('sesi-jadwal.notes');

        // Feedback
        Route::resource('feedback', FeedbackController::class)->names('feedback');

        // Availability management
        Route::post('/availability',        [MentorDashboardController::class, 'storeAvailability'])->name('availability.store');
        Route::put('/availability/{id}',    [MentorDashboardController::class, 'updateAvailability'])->name('availability.update');
        Route::delete('/availability/{id}', [MentorDashboardController::class, 'destroyAvailability'])->name('availability.destroy');

        // Booking actions
        Route::post('/bookings/{id}/accept', [MentorDashboardController::class, 'acceptBooking'])->name('bookings.accept');
        Route::post('/bookings/{id}/reject', [MentorDashboardController::class, 'rejectBooking'])->name('bookings.reject');
    });
});