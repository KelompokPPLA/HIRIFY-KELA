<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\AuthForgotPasswordRequest;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Requests\AuthResetPasswordRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function forgotPassword(AuthForgotPasswordRequest $request)
    {
        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_THROTTLED) {
            return ResponseHelper::jsonResponse(false, __($status), null, 429);
        }

        // Response disamakan agar tidak membocorkan email terdaftar atau tidak.
        return ResponseHelper::jsonResponse(true, 'Jika email terdaftar, link reset password akan dikirim.', null, 200);
    }

    public function resetPassword(AuthResetPasswordRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => $password,
                    'remember_token' => Str::random(60),
                ])->save();

                $user->tokens()->delete();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return ResponseHelper::jsonResponse(true, __($status), null, 200);
        }

        return ResponseHelper::jsonResponse(false, __($status), null, 422);
    }

    public function register(AuthRegisterRequest $request)
    {
        try {
            $validated = $request->validated();

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => $validated['role'] ?? 'jobseeker',
            ]);

            $token = $user->createToken($request->input('device_name', 'web-app'))->plainTextToken;

            return ResponseHelper::jsonResponse(true, 'Register berhasil.', [
                'token' => $token,
                'token_type' => 'Bearer',
                'user' => new UserResource($user),
            ], 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function login(AuthLoginRequest $request)
    {
        $validated = $request->validated();

        try {
            $user = User::where('email', $validated['email'])->first();

            if (! $user || ! Hash::check($validated['password'], $user->password)) {
                return ResponseHelper::jsonResponse(false, 'Email atau password salah.', null, 422);
            }

            $token = $user->createToken($validated['device_name'] ?? 'web-app')->plainTextToken;

            return ResponseHelper::jsonResponse(true, 'Login berhasil.', [
                'token' => $token,
                'token_type' => 'Bearer',
                'user' => new UserResource($user),
            ], 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function me(Request $request)
    {
        return ResponseHelper::jsonResponse(true, 'Profil user berhasil diambil.', new UserResource($request->user()), 200);
    }

    public function logout(Request $request)
    {
        try {
            $request->user()?->currentAccessToken()?->delete();

            return ResponseHelper::jsonResponse(true, 'Logout berhasil.', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function logoutAll(Request $request)
    {
        try {
            $request->user()?->tokens()->delete();

            return ResponseHelper::jsonResponse(true, 'Semua sesi berhasil di-logout.', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
