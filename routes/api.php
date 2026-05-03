<?php

use App\Http\Controllers\AdminStatisticsController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CvApiController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\MentorCertificationController;
use App\Http\Controllers\MentorshipController;
use App\Http\Controllers\MentorProfileController;
use App\Http\Controllers\RoadmapController;
use App\Http\Controllers\SelfAssessmentController;
use App\Http\Controllers\SkillTrainingController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ============= PUBLIC API AUTH ROUTES =============
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);

    // Refresh can be called with expired token – must stay outside auth:api
    Route::post('refresh', [AuthController::class, 'refresh']);

    // Protected auth routes
    Route::middleware('auth:api')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('logout-all', [AuthController::class, 'logoutAll']);
    });
});

// ============= ADMIN ROUTES (JWT) =============
Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::apiResource('user', UserController::class);
    Route::get('user/all/paginated', [UserController::class, 'getAllPaginated']);
	// Admin CRUD for mentors and training modules
	Route::apiResource('mentor', \App\Http\Controllers\Admin\MentorController::class);
	Route::apiResource('module', \App\Http\Controllers\Admin\ModuleController::class);
    Route::get('admin/statistics', [AdminStatisticsController::class, 'index']);
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

// ============= FORUM ROUTES (JWT) =============
Route::middleware('auth:api')->prefix('forum')->group(function () {
    Route::get('threads', [ForumController::class, 'index']);
    Route::post('threads', [ForumController::class, 'store']);
    Route::get('threads/{id}', [ForumController::class, 'show']);
    Route::put('threads/{id}', [ForumController::class, 'updateThread']);
    Route::delete('threads/{id}', [ForumController::class, 'destroyThread']);
    Route::post('threads/{id}/comments', [ForumController::class, 'addComment']);
    Route::put('threads/{id}/comments/{commentId}', [ForumController::class, 'updateComment']);
    Route::delete('threads/{id}/comments/{commentId}', [ForumController::class, 'destroyComment']);
});

// ============= SKILL TRAINING ROUTES (JWT, jobseeker) =============
Route::middleware(['auth:api', 'role:jobseeker'])->prefix('skill-training')->group(function () {
    Route::get('courses', [SkillTrainingController::class, 'catalog']);
    Route::get('courses/{id}', [SkillTrainingController::class, 'courseDetail']);
    Route::post('courses/{id}/enroll', [SkillTrainingController::class, 'enroll']);
    Route::post('courses/{courseId}/lessons/{lessonId}/complete', [SkillTrainingController::class, 'completeLesson']);
    Route::get('my-courses', [SkillTrainingController::class, 'myEnrollments']);
});

// ============= SELF ASSESSMENT ROUTES (JWT, jobseeker) =============
Route::middleware(['auth:api', 'role:jobseeker'])->prefix('self-assessment')->group(function () {
    Route::get('questions', [SelfAssessmentController::class, 'getQuestions']);
    Route::get('/', [SelfAssessmentController::class, 'index']);
    Route::post('/', [SelfAssessmentController::class, 'store']);
});

// ============= ROADMAP ROUTES (JWT, jobseeker) =============
Route::middleware(['auth:api', 'role:jobseeker'])->prefix('roadmap-karier')->group(function () {
    Route::get('/', [RoadmapController::class, 'index']);
    Route::post('select', [RoadmapController::class, 'select']);
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
    Route::get('cv', [CvApiController::class, 'index']);
    Route::post('cv', [CvApiController::class, 'store']);
    Route::get('cv/{id}', [CvApiController::class, 'show']);
    Route::put('cv/{id}', [CvApiController::class, 'update']);
    Route::delete('cv/{id}', [CvApiController::class, 'destroy']);
});
