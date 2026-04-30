<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

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
