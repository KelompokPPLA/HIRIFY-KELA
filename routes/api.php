<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
	Route::post('register', [AuthController::class, 'register']);
	Route::post('login', [AuthController::class, 'login']);
	Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
	Route::post('reset-password', [AuthController::class, 'resetPassword']);

	Route::middleware('auth:sanctum')->group(function () {
		Route::get('me', [AuthController::class, 'me']);
		Route::post('logout', [AuthController::class, 'logout']);
		Route::post('logout-all', [AuthController::class, 'logoutAll']);
	});
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
	Route::apiResource('user', UserController::class);
	Route::get('user/all/paginated', [UserController::class, 'getAllPaginated']);
});
