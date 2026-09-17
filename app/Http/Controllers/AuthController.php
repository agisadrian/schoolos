<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Batas maksimal percobaan login gagal sebelum
     * dikunci sementara.
     */
    private const MAX_LOGIN_ATTEMPTS = 5;

    /**
     * Lama waktu kunci (detik) setelah melewati batas
     * percobaan di atas.
     */
    private const LOGIN_LOCKOUT_SECONDS = 60;

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $throttleKey = $this->throttleKey($request);

        if (RateLimiter::tooManyAttempts($throttleKey, self::MAX_LOGIN_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()
                ->withErrors([
                    'email' => 'Terlalu banyak percobaan login. ' .
                        'Coba lagi dalam ' . $seconds . ' detik.',
                ])
                ->onlyInput('email');
        }

        if (Auth::attempt($credentials)) {
            RateLimiter::clear($throttleKey);

            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        RateLimiter::hit($throttleKey, self::LOGIN_LOCKOUT_SECONDS);

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Kunci rate limit dibuat dari kombinasi email + IP,
     * supaya satu penyerang yang nyoba banyak email dari
     * IP yang sama tetap kena limit, tapi user lain yang
     * kebetulan satu jaringan (misal satu sekolah/wifi)
     * tidak ikut terkunci gara-gara orang lain gagal login.
     */
    private function throttleKey(Request $request): string
    {
        return Str::lower((string) $request->input('email')) .
            '|' . $request->ip();
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /*
    |--------------------------------------------------------------------------
    | Lupa Password
    |--------------------------------------------------------------------------
    */

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Selalu tampilkan pesan sukses yang sama, terlepas
        // dari email-nya terdaftar atau tidak. Ini standar
        // praktik keamanan supaya orang luar tidak bisa
        // "menebak" email mana saja yang punya akun di
        // sistem ini (email enumeration).
        Password::sendResetLink(
            $request->only('email')
        );

        return back()->with(
            'success',
            'Kalau email tersebut terdaftar, link reset ' .
            'password sudah kami kirim. Silakan cek inbox ' .
            '(dan folder spam) email kamu.'
        );
    }

    public function showResetPassword(string $token, Request $request)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $status = Password::reset(
            $validated,
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()
                ->route('login')
                ->with(
                    'success',
                    'Password berhasil diganti. Silakan login ' .
                    'dengan password baru kamu.'
                );
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => $this->translateResetError($status),
            ]);
    }

    private function translateResetError(string $status): string
    {
        return match ($status) {
            Password::INVALID_USER =>
                'Email tidak ditemukan di sistem kami.',
            Password::INVALID_TOKEN =>
                'Link reset password sudah tidak valid atau ' .
                'kedaluwarsa. Silakan minta link baru.',
            Password::RESET_THROTTLED =>
                'Mohon tunggu sebentar sebelum meminta reset ' .
                'password lagi.',
            default =>
                'Gagal mereset password. Silakan coba lagi.',
        };
    }
}