<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Register user (API).
     */
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

            $token = JWTAuth::fromUser($user);

            if (!$token) {
                return ResponseHelper::jsonResponse(false, 'Gagal membuat token JWT.', null, 500);
            }

            return $this->respondWithToken($token, $user, 201, 'Register berhasil.');
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Login user (API).
     */
    public function login(AuthLoginRequest $request)
    {
        $validated = $request->validated();

        try {
            $credentials = [
                'email' => $validated['email'],
                'password' => $validated['password'],
            ];

            if (!$token = Auth::guard('api')->attempt($credentials)) {
                return ResponseHelper::jsonResponse(false, 'Email atau password salah.', null, 422);
            }

            $user = Auth::guard('api')->user();

            return $this->respondWithToken($token, $user, 200, 'Login berhasil.');
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Get authenticated user (API).
     */
    public function me(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            return ResponseHelper::jsonResponse(true, 'Profil user berhasil diambil.', new UserResource($user), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Token tidak valid atau sudah kadaluarsa.', null, 401);
        }
    }

    /**
     * Refresh JWT token.
     */
    public function refresh()
    {
        try {
            $token = JWTAuth::parseToken()->refresh();
            $user = JWTAuth::setToken($token)->toUser();

            return $this->respondWithToken($token, $user, 200, 'Token berhasil diperbarui.');
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Token tidak valid atau sudah kadaluarsa.', null, 401);
        }
    }

    /**
     * Logout user (API).
     */
    public function logout(Request $request)
    {
        try {
            JWTAuth::parseToken()->invalidate();

            return ResponseHelper::jsonResponse(true, 'Logout berhasil.', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Logout all sessions (API).
     */
    public function logoutAll(Request $request)
    {
        try {
            JWTAuth::parseToken()->invalidate();

            return ResponseHelper::jsonResponse(
                true,
                'Token aktif berhasil di-logout. Untuk JWT, logout-all lintas perangkat memerlukan strategi blacklist tambahan.',
                null,
                200
            );
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Send password reset link (API).
     */
    public function forgotPassword(\App\Http\Requests\AuthForgotPasswordRequest $request)
    {
        $status = \Illuminate\Support\Facades\Password::sendResetLink($request->only('email'));

        if ($status === \Illuminate\Support\Facades\Password::RESET_THROTTLED) {
            return ResponseHelper::jsonResponse(false, __($status), null, 429);
        }

        return ResponseHelper::jsonResponse(true, 'Jika email terdaftar, link reset password akan dikirim.', null, 200);
    }

    /**
     * Reset password (API).
     */
    public function resetPassword(\App\Http\Requests\AuthResetPasswordRequest $request)
    {
        $status = \Illuminate\Support\Facades\Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => $password,
                    'remember_token' => \Illuminate\Support\Str::random(60),
                ])->save();

                event(new \Illuminate\Auth\Events\PasswordReset($user));
            }
        );

        if ($status === \Illuminate\Support\Facades\Password::PASSWORD_RESET) {
            return ResponseHelper::jsonResponse(true, __($status), null, 200);
        }

        return ResponseHelper::jsonResponse(false, __($status), null, 422);
    }

    /**
     * Respond with token.
     */
    private function respondWithToken(string $token, User $user, int $statusCode = 200, string $message = 'Berhasil')
    {
        return ResponseHelper::jsonResponse(true, $message, [
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => (int) config('jwt.ttl', 60) * 60,
            'user' => new UserResource($user),
        ], $statusCode);
    }
}
