<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\MentorCertificationController;
use App\Http\Controllers\MentorshipController;
use App\Http\Controllers\MentorProfileController;
use App\Http\Controllers\SkillTrainingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CvController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ============= PUBLIC API AUTH ROUTES =============
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);

    // Protected auth routes
    Route::middleware('auth:api')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('logout-all', [AuthController::class, 'logoutAll']);
    });
});

// ============= ADMIN ROUTES (JWT) =============
Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::apiResource('user', UserController::class);
    Route::get('user/all/paginated', [UserController::class, 'getAllPaginated']);
});

// ============= MENTOR ROUTES (JWT) =============
Route::middleware(['auth:api', 'role:mentor'])->prefix('mentor')->group(function () {
    Route::get('profile', [MentorProfileController::class, 'show']);
    Route::put('profile', [MentorProfileController::class, 'update']);
    Route::post('profile/avatar', [MentorProfileController::class, 'updateAvatar']);
    Route::get('certifications', [MentorCertificationController::class, 'index']);
    Route::post('certifications', [MentorCertificationController::class, 'store']);
    Route::delete('certifications/{id}', [MentorCertificationController::class, 'destroy']);
});

// ============= JOBSEEKER ROUTES (JWT) =============
Route::middleware(['auth:api', 'role:jobseeker'])->prefix('mentorship')->group(function () {
    Route::get('mentors', [MentorshipController::class, 'mentors']);
    Route::get('mentors/{id}', [MentorshipController::class, 'mentorDetail']);
    Route::get('mentors/{id}/availability', [MentorshipController::class, 'mentorAvailability']);
    Route::post('bookings', [MentorshipController::class, 'createBooking']);
    Route::get('bookings/my', [MentorshipController::class, 'myBookings']);
    Route::patch('bookings/{id}/cancel', [MentorshipController::class, 'cancelBooking']);
});

// ============= CV ROUTES (JWT) =============
Route::middleware(['auth:api'])->group(function () {
    Route::get('buat-cv-ats', [CvController::class, 'index']);
    Route::post('buat-cv-ats', [CvController::class, 'store']);
});