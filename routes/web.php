<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\CvController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MentorDashboardController;
use App\Http\Controllers\SesiJadwalController;
use App\Http\Controllers\FeedbackController;

Route::get('/', fn() => redirect()->route('dashboard'));

Route::view('/login', 'auth.login')->name('login');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'loginWeb'])->name('login.post');
Route::view('/register', 'auth.register')->name('register');
Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');
Route::view('/reset-password', 'auth.reset-password')->name('password.reset');
Route::post('/logout', function () {
    auth()->logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/login');
})->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
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
// ============= PUBLIC AUTH ROUTES (No Auth Required) =============
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

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