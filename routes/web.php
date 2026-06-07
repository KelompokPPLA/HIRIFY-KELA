<?php

use Illuminate\Support\Facades\Route;

/* ================= CONTROLLERS ================= */
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\AdminStatisticsController;
use App\Http\Controllers\AdminTrainingModuleController;
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
use App\Http\Controllers\GenerateController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\StreakController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\AdminMentorManagementController;
use App\Http\Controllers\JobseekerFeedbackController;

Route::get('/', function () {
    return view('welcome');
});

// Verifikasi sertifikat (publik, tanpa auth)
Route::get('/sertifikat/verifikasi', [CertificateController::class, 'verify'])->name('certificates.verify');

/* ============================================================
   PUBLIC ROUTES (GUEST ONLY)
============================================================ */
Route::middleware('guest')->group(function () {

    // AUTH
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // PASSWORD RESET — Email Link (DEV-139)
    Route::get('/forgot-password',  [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.send-link');

    Route::get('/reset-password',  [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetWithToken'])->name('password.reset.token');

    // PASSWORD RESET — OTP (existing flow)
    Route::post('/forgot-password-otp', [AuthController::class, 'sendOtp'])->name('password.send-otp');
    Route::get('/reset-password-otp',   [AuthController::class, 'showOtpReset'])->name('password.otp.show');
    Route::post('/reset-password-otp',  [AuthController::class, 'resetWithOtp'])->name('password.otp.reset');
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

    // Halaman list semua CV milik user
    Route::get('/cv',                [CvController::class, 'index'])   ->name('cv.index');

    // halaman buat CV ATS
    Route::get('/buat-cv-ats', [CvController::class, 'create'])->name('buat-cv-ats.index');

    // handle buat CV ATS (form submit)
    Route::post('/buat-cv-ats', [GenerateController::class, 'store'])->name('buat-cv-ats.store');
    Route::get('/buat-cv-ats', [CvController::class, 'create'])->name('buat-cv-ats.create');
    Route::post('/buat-cv-ats', [CvController::class, 'store'])->name('buat-cv-ats.store');

    // Upload CV (PDF) — specific routes BEFORE {id} catch-all
    Route::post('/cv/upload',        [CvController::class, 'uploadFile'])->name('cv.upload');

    // Legacy/resource-compatible create route (used by some views)
    Route::get('/cv/create', [CvController::class, 'create'])->name('cv.create');

    // generate CV
    Route::post('/cv', [GenerateController::class, 'store'])->name('cv.store');

    // Lihat CV
    Route::get('/cv/{id}', [CvController::class, 'show'])->name('cv.show');

    // Download CV sebagai PDF
    Route::get('/cv/{id}/download',  [CvController::class, 'download'])->name('cv.download');

    // Update data CV
    Route::put('/cv/{id}',           [CvController::class, 'update'])  ->name('cv.update');

    // Ganti file CV (upload ulang PDF)
    Route::post('/cv/{id}/replace',  [CvController::class, 'replaceFile'])->name('cv.replace');

    // Hapus CV
    Route::delete('/cv/{id}',        [CvController::class, 'destroy']) ->name('cv.destroy');

    // Halaman manajemen CV (redirect ke cv.index)
    Route::get('/manajemen-cv',      [CvController::class, 'index'])   ->name('manajemen-cv.index');

    // Generate CV via API
    Route::post('/cv/generate',      [GenerateController::class, 'store'])->name('cv.generate');

    // CV presentasi (menggunakan CvPresentationController)
    Route::get('/buat-cv-presentasi', [\App\Http\Controllers\CvPresentationController::class, 'index'])->name('buat-cv-presentasi.index');

    /* ---------- Portofolio Management ---------- */
    Route::resource('portofolio', PortofolioController::class);

    /* ---------- Roadmap & Assessment ---------- */
    /* ---------- ROADMAP KARIER ---------- */
    Route::get('/roadmap-karier',        [RoadmapController::class, 'index'])->name('roadmap-karier.index');
    Route::post('/roadmap-karier',       [RoadmapController::class, 'store'])->name('roadmap-karier.store');
    Route::patch('/roadmap-karier/{id}', [RoadmapController::class, 'update'])->name('roadmap-karier.update');

    /* ---------- SELF ASSESSMENT ---------- */
    Route::get('/self-assessment',   [SelfAssessmentController::class, 'index'])->name('self-assessment.index');
    Route::post('/self-assessment',  [SelfAssessmentController::class, 'store'])->name('assessment.store');
    Route::get('/assessment/result', [SelfAssessmentController::class, 'result'])->name('assessment.result');


    /* ---------- STATIC PAGES ---------- */
    Route::view('/pelatihan', 'jobseeker.skill-training')->name('pelatihan.index');
    Route::view('/skill-training', 'jobseeker.skill-training')->name('skill-training.index');
    Route::view('/forum', 'forum.index')->name('forum.index');

    // Notifikasi
    // Notifikasi
Route::get('/notifikasi', [NotificationController::class, 'index'])
    ->name('notifikasi.index');

Route::post('/notifikasi/read-all', [NotificationController::class, 'markAllAsRead'])
    ->name('notifikasi.read-all');

Route::patch('/notifikasi/{notification}/read', [NotificationController::class, 'markAsRead'])
    ->name('notifikasi.read');

Route::get('/riwayat-feedback', [JobseekerFeedbackController::class, 'index'])->name('jobseeker.feedback.index');
    // Mentorship
    Route::get('/mentorship', [\App\Http\Controllers\Web\MentorshipPageController::class, 'index'])->name('mentorship.index');

    /* ---------- Career Streak ---------- */
    Route::get('/streak',         [StreakController::class, 'index'])->name('streak.index');
    Route::get('/streak/history', [StreakController::class, 'history'])->name('streak.history');

    /* ---------- Lowongan Kerja (DEV-126) ---------- */
    Route::get('/lowongan',      [JobController::class, 'index'])->name('jobs.index');
    Route::get('/lowongan/{id}', [JobController::class, 'show'])->name('jobs.show');

    /* ---------- Sertifikat Pelatihan (DEV-133) ---------- */
    Route::get('/sertifikat',                    [CertificateController::class, 'index'])->name('certificates.index');
    Route::get('/sertifikat/generate-completed', [CertificateController::class, 'generateForCompleted'])->name('certificates.generate');
    Route::get('/sertifikat/{id}',               [CertificateController::class, 'show'])->name('certificates.show');
    Route::get('/sertifikat/{id}/unduh',         [CertificateController::class, 'download'])->name('certificates.download');


    /* ---------- AUTH ACTION ---------- */
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/me', [AuthController::class, 'me'])->name('auth.me');

    // ---- Admin Routes ----
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/statistics', [AdminStatisticsController::class, 'show'])->name('admin.statistics');
        // Admin user management
        Route::get('/admin/users', [AdminStatisticsController::class, 'users'])->name('admin.users');
        Route::get('/admin/users/create', [\App\Http\Controllers\AdminUserManagementController::class, 'create'])->name('admin.users.create');
        Route::post('/admin/users', [\App\Http\Controllers\AdminUserManagementController::class, 'store'])->name('admin.users.store');
        Route::get('/admin/users/{user}/edit', [\App\Http\Controllers\AdminUserManagementController::class, 'edit'])->name('admin.users.edit');
        Route::patch('/admin/users/{user}', [\App\Http\Controllers\AdminUserManagementController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [\App\Http\Controllers\AdminUserManagementController::class, 'destroy'])->name('admin.users.destroy');
        // Admin mentor management (index, create, store, edit, update, destroy)
        Route::get('/admin/mentors', [AdminMentorManagementController::class, 'index'])->name('admin.mentors.index');
        Route::get('/admin/mentors/create', [AdminMentorManagementController::class, 'create'])->name('admin.mentors.create');
        Route::post('/admin/mentors', [AdminMentorManagementController::class, 'store'])->name('admin.mentors.store');
        Route::get('/admin/mentors/{mentor}/edit', [AdminMentorManagementController::class, 'edit'])->name('admin.mentors.edit');
        Route::patch('/admin/mentors/{mentor}', [AdminMentorManagementController::class, 'update'])->name('admin.mentors.update');
        Route::delete('/admin/mentors/{mentor}', [AdminMentorManagementController::class, 'destroy'])->name('admin.mentors.destroy');
        // Admin training modules
        Route::get('/admin/training-modules', [AdminTrainingModuleController::class, 'index'])->name('admin.training-modules.index');
        Route::get('/admin/training-modules/create', [AdminTrainingModuleController::class, 'create'])->name('admin.training-modules.create');
        Route::post('/admin/training-modules', [AdminTrainingModuleController::class, 'store'])->name('admin.training-modules.store');
        Route::get('/admin/training-modules/{trainingModule}/edit', [AdminTrainingModuleController::class, 'edit'])->name('admin.training-modules.edit');
        Route::patch('/admin/training-modules/{trainingModule}', [AdminTrainingModuleController::class, 'update'])->name('admin.training-modules.update');
        Route::delete('/admin/training-modules/{trainingModule}', [AdminTrainingModuleController::class, 'destroy'])->name('admin.training-modules.destroy');
        Route::get('/admin/activity', [AdminStatisticsController::class, 'activity'])->name('admin.activity');

        // Admin Mentor Management
        Route::get('/admin/mentors', [AdminMentorManagementController::class, 'index'])->name('admin.mentors.index');
        Route::get('/admin/mentors/create', [AdminMentorManagementController::class, 'create'])->name('admin.mentors.create');
        Route::post('/admin/mentors', [AdminMentorManagementController::class, 'store'])->name('admin.mentors.store');
        Route::get('/admin/mentors/{id}/edit', [AdminMentorManagementController::class, 'edit'])->name('admin.mentors.edit');
        Route::put('/admin/mentors/{id}', [AdminMentorManagementController::class, 'update'])->name('admin.mentors.update');
        Route::delete('/admin/mentors/{id}', [AdminMentorManagementController::class, 'destroy'])->name('admin.mentors.destroy');

        // Admin Training Module Management
        Route::get('/admin/training-modules', [AdminTrainingModuleController::class, 'index'])->name('admin.training-modules.index');
        Route::get('/admin/training-modules/create', [AdminTrainingModuleController::class, 'create'])->name('admin.training-modules.create');
        Route::post('/admin/training-modules', [AdminTrainingModuleController::class, 'store'])->name('admin.training-modules.store');
        Route::get('/admin/training-modules/{trainingModule}/edit', [AdminTrainingModuleController::class, 'edit'])->name('admin.training-modules.edit');
        Route::put('/admin/training-modules/{trainingModule}', [AdminTrainingModuleController::class, 'update'])->name('admin.training-modules.update');
        Route::delete('/admin/training-modules/{trainingModule}', [AdminTrainingModuleController::class, 'destroy'])->name('admin.training-modules.destroy');
    });


    // ---- Mentor Routes ----
    Route::prefix('mentor')->group(function () {
        Route::get('/dashboard', [MentorDashboardController::class, 'index'])->name('mentor.dashboard');
        Route::view('/settings', 'mentor.settings')->name('mentor.settings');
        Route::resource('sesi-jadwal', SesiJadwalController::class)->names('mentor.sesi-jadwal');
        Route::post('sesi-jadwal/{id}/notes', [SesiJadwalController::class, 'addNotes'])->name('mentor.sesi-jadwal.notes');
        Route::resource('feedback', FeedbackController::class)->names('mentor.feedback');
        Route::get('/mentee', [MenteeSayaController::class, 'index'])->name('mentor.mentee.index');
        Route::get('/mentee/{id}', [MenteeSayaController::class, 'show'])->name('mentor.mentee.show');

        // availability
        Route::post('/availability',        [MentorDashboardController::class, 'storeAvailability'])->name('availability.store');
        Route::put('/availability/{id}',    [MentorDashboardController::class, 'updateAvailability'])->name('availability.update');
        Route::delete('/availability/{id}', [MentorDashboardController::class, 'destroyAvailability'])->name('availability.destroy');

        // booking
        Route::post('/bookings/{id}/accept', [MentorDashboardController::class, 'acceptBooking'])->name('mentor.bookings.accept');
        Route::post('/bookings/{id}/reject', [MentorDashboardController::class, 'rejectBooking'])->name('mentor.bookings.reject');
    });

});
