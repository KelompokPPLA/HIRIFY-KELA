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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

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

            $token = JWTAuth::fromUser($user);

            if (! $token) {
                return ResponseHelper::jsonResponse(false, 'Gagal membuat token JWT.', null, 500);
            }

            return $this->respondWithToken($token, $user, 201, 'Register berhasil.');
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function login(AuthLoginRequest $request)
    {
        $validated = $request->validated();

        try {
            $credentials = [
                'email' => $validated['email'],
                'password' => $validated['password'],
            ];

            if (! $token = Auth::guard('api')->attempt($credentials)) {
                return ResponseHelper::jsonResponse(false, 'Email atau password salah.', null, 422);
            }

            $user = Auth::guard('api')->user();

            return $this->respondWithToken($token, $user, 200, 'Login berhasil.');
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function loginWeb(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password'],
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak valid.',
        ]);
    }

    public function me(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        return ResponseHelper::jsonResponse(true, 'Profil user berhasil diambil.', new UserResource($user), 200);
    }

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

    public function logout(Request $request)
    {
        try {
            JWTAuth::parseToken()->invalidate();

            return ResponseHelper::jsonResponse(true, 'Logout berhasil.', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function logoutAll(Request $request)
    {
        try {
            JWTAuth::parseToken()->invalidate();

            return ResponseHelper::jsonResponse(true, 'Token aktif berhasil di-logout. Untuk JWT, logout-all lintas perangkat memerlukan strategi blacklist tambahan.', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

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
