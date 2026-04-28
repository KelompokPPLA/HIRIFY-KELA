<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', fn() => redirect()->route('dashboard'));

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/profile', fn() => view('profile.index'))->name('profile');
Route::get('/manajemen-cv', fn() => view('manajemen-cv.index'))->name('manajemen-cv');
Route::get('/buat-cv-ats', fn() => view('buat-cv-ats.index'))->name('buat-cv-ats');
Route::get('/roadmap-karier', fn() => view('roadmap-karier.index'))->name('roadmap-karier');
Route::get('/self-assessment', fn() => view('self-assessment.index'))->name('self-assessment');
Route::get('/pelatihan', fn() => view('pelatihan.index'))->name('pelatihan');
Route::get('/mentorship', fn() => view('mentorship.index'))->name('mentorship');
Route::get('/notifikasi', fn() => view('notifikasi.index'))->name('notifikasi');