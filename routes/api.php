<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MentorCertificationController;
use App\Http\Controllers\MentorshipController;
use App\Http\Controllers\MentorProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
	Route::post('register', [AuthController::class, 'register']);
	Route::post('login', [AuthController::class, 'login']);
	Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
	Route::post('reset-password', [AuthController::class, 'resetPassword']);

	Route::middleware('auth:api')->group(function () {
		Route::get('me', [AuthController::class, 'me']);
		Route::post('refresh', [AuthController::class, 'refresh']);
		Route::post('logout', [AuthController::class, 'logout']);
		Route::post('logout-all', [AuthController::class, 'logoutAll']);
	});
});

Route::middleware(['auth:api', 'role:admin'])->group(function () {
	Route::apiResource('user', UserController::class);
	Route::get('user/all/paginated', [UserController::class, 'getAllPaginated']);
});

Route::middleware(['auth:api', 'role:mentor'])->prefix('mentor')->group(function () {
	Route::get('profile', [MentorProfileController::class, 'show']);
	Route::put('profile', [MentorProfileController::class, 'update']);
	Route::post('profile/avatar', [MentorProfileController::class, 'updateAvatar']);
	Route::get('certifications', [MentorCertificationController::class, 'index']);
	Route::post('certifications', [MentorCertificationController::class, 'store']);
	Route::delete('certifications/{id}', [MentorCertificationController::class, 'destroy']);

	// Mentor Dashboard
	Route::get('dashboard', [MentorDashboardController::class, 'index']);
	Route::post('availability', [MentorDashboardController::class, 'storeAvailability']);
	Route::put('availability/{id}', [MentorDashboardController::class, 'updateAvailability']);
	Route::delete('availability/{id}', [MentorDashboardController::class, 'destroyAvailability']);
	Route::post('bookings/{id}/accept', [MentorDashboardController::class, 'acceptBooking']);
	Route::post('bookings/{id}/reject', [MentorDashboardController::class, 'rejectBooking']);
});

Route::middleware(['auth:api', 'role:jobseeker'])->prefix('mentorship')->group(function () {
	Route::get('mentors', [MentorshipController::class, 'mentors']);
	Route::get('mentors/{id}', [MentorshipController::class, 'mentorDetail']);
	Route::get('mentors/{id}/availability', [MentorshipController::class, 'mentorAvailability']);
	Route::post('bookings', [MentorshipController::class, 'createBooking']);
	Route::get('bookings/my', [MentorshipController::class, 'myBookings']);
	Route::patch('bookings/{id}/cancel', [MentorshipController::class, 'cancelBooking']);
});
