<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\LoginRequest;
use App\Http\Requests\Web\RegisterRequest;
use App\Mail\ResetPasswordMail;
use App\Models\PasswordOtp;
use App\Models\PasswordResetLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Show login form.
     */
    public function showLogin()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Handle login request (session-based, no JWT).
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Generate JWT token for API calls (mentorship, etc.)
            try {
                $jwtToken = JWTAuth::fromUser(Auth::user());
                $request->session()->put('jwt_token', $jwtToken);
            } catch (\Exception $e) {
                // JWT generation failed, proceed without it
            }

            $redirectRoute = Auth::user()->role === 'admin'
                ? route('admin.statistics')
                : route('dashboard');

            // Jika request JSON (fetch dari JS), kirim JSON
            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'success'  => true,
                    'message'  => 'Login berhasil.',
                    'redirect' => $redirectRoute,
                ], 200);
            }

            // Fallback: redirect langsung (form POST biasa)
            return redirect()->intended($redirectRoute);
        }

        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password tidak valid.',
            ], 422);
        }

        return back()
            ->withErrors(['email' => 'Email atau password tidak valid.'])
            ->withInput($request->only('email', 'remember'));
    }

    /**
     * Show register form.
     */
    public function showRegister()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }

    /**
     * Handle register request (session-based).
     */
    public function register(RegisterRequest $request)
    {
        try {
            $validated = $request->validated();

            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role'     => $validated['role'] ?? 'jobseeker',
            ]);

            Auth::login($user);
            $request->session()->regenerate();

            // Generate JWT token for API-backed pages after registration.
            try {
                $jwtToken = JWTAuth::fromUser($user);
                $request->session()->put('jwt_token', $jwtToken);
            } catch (\Exception $e) {
                // JWT generation failed, proceed with the web session.
            }

            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'success'  => true,
                    'message'  => 'Register berhasil. Anda akan diarahkan ke dashboard.',
                    'redirect' => route('dashboard'),
                ], 201);
            }

            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 500);
            }

            return back()->withErrors(['email' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Get authenticated user (session-based).
     */
    public function me(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Profil user berhasil diambil.',
            'user'    => auth()->user(),
        ], 200);
    }

    /**
     * Logout user (session-based).
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->forget('jwt_token');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil.',
            ], 200);
        }

        return redirect()->route('login');
    }

    /**
     * Show forgot password form.
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Kirim link reset password ke email (token-based, valid 60 menit).
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = $request->input('email');
        $user  = User::where('email', $email)->first();

        // Selalu tampilkan pesan yang sama untuk mencegah email enumeration
        $genericMessage = 'Jika email terdaftar, link reset password telah dikirim. Periksa kotak masuk Anda.';

        if (! $user) {
            return back()->with('status', $genericMessage)->withInput();
        }

        // Hapus token lama yang belum dipakai agar tidak menumpuk
        PasswordResetLog::where('email', $email)
            ->where('status', 'requested')
            ->update(['status' => 'expired']);

        $token     = Str::random(64);
        $expiresAt = now()->addMinutes(60);

        // Simpan ke tabel password_reset_logs untuk audit
        PasswordResetLog::create([
            'email'      => $email,
            'token'      => hash('sha256', $token),
            'status'     => 'requested',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'expires_at' => $expiresAt,
        ]);

        $resetUrl = route('password.reset', [
            'token' => $token,
            'email' => $email,
        ]);

        Mail::to($email)->send(new ResetPasswordMail($resetUrl, $user->name, '60'));

        return back()->with('status', $genericMessage);
    }

    /**
     * Show reset password form (token-based dari email link).
     */
    public function showResetPassword(Request $request)
    {
        $token = $request->query('token');
        $email = $request->query('email');

        if (! $token || ! $email) {
            return redirect()->route('password.request')
                ->with('error', 'Link reset password tidak valid.');
        }

        $log = PasswordResetLog::where('email', $email)
            ->where('token', hash('sha256', $token))
            ->where('status', 'requested')
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (! $log) {
            return redirect()->route('password.request')
                ->with('error', 'Link reset password sudah kadaluarsa atau tidak valid. Silakan minta link baru.');
        }

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    /**
     * Proses reset password menggunakan token dari email.
     */
    public function resetWithToken(Request $request)
    {
        $validated = $request->validate([
            'token'                 => 'required|string',
            'email'                 => 'required|email',
            'password'              => 'required|string|min:8|confirmed|regex:/^(?=.*[A-Za-z])(?=.*\d).+$/',
            'password_confirmation' => 'required|string|min:8',
        ], [
            'password.regex' => 'Password harus mengandung minimal 1 huruf dan 1 angka.',
        ]);

        $log = PasswordResetLog::where('email', $validated['email'])
            ->where('token', hash('sha256', $validated['token']))
            ->where('status', 'requested')
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (! $log) {
            return back()->withErrors(['token' => 'Link reset password tidak valid atau sudah kadaluarsa.']);
        }

        $user = User::where('email', $validated['email'])->first();

        if (! $user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        $user->forceFill([
            'password' => Hash::make($validated['password']),
        ])->save();

        $log->markAsUsed();

        return redirect()->route('login')
            ->with('success', 'Password berhasil diubah. Silakan login dengan password baru Anda.');
    }

    /**
     * Generate OTP for password reset and redirect to OTP page.
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');

        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()
                ->withErrors(['email' => 'Email tidak terdaftar di sistem.'])
                ->withInput();
        }

        $otp = (string) random_int(100000, 999999);

        PasswordOtp::where('email', $email)->whereNull('used_at')->delete();

        PasswordOtp::create([
            'email' => $email,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(10),
        ]);

        return redirect()
            ->route('password.otp.show', ['email' => $email])
            ->with('otp_code', $otp)
            ->with('success', 'Kode OTP berhasil dibuat. Gunakan kode di bawah untuk reset password.');
    }

    /**
     * Show the OTP verification + new password form.
     */
    public function showOtpReset(Request $request)
    {
        $email = $request->query('email');

        if (!$email) {
            return redirect()->route('password.request');
        }

        $latestOtp = PasswordOtp::where('email', $email)
            ->whereNull('used_at')
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        return view('auth.reset-password-otp', [
            'email' => $email,
            'otpCode' => session('otp_code') ?? optional($latestOtp)->otp,
        ]);
    }

    /**
     * Verify OTP and reset password.
     */
    public function resetWithOtp(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $otpRecord = PasswordOtp::where('email', $validated['email'])
            ->where('otp', $validated['otp'])
            ->whereNull('used_at')
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (!$otpRecord) {
            return back()
                ->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kadaluarsa.'])
                ->withInput($request->only('email'));
        }

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            return back()
                ->withErrors(['email' => 'Email tidak terdaftar.'])
                ->withInput($request->only('email'));
        }

        $user->forceFill([
            'password' => Hash::make($validated['password']),
        ])->save();

        $otpRecord->update(['used_at' => now()]);

        return redirect()
            ->route('login')
            ->with('success', 'Password berhasil diubah. Silakan login dengan password baru.');
    }
}
