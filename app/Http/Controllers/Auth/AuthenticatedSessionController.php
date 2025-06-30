<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login'); // Pastikan Anda memiliki view ini atau sesuaikan
    }

    /**
     * Handle an incoming authentication request.
     * --- METHOD INI YANG KITA MODIFIKASI ---
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Lakukan percobaan autentikasi seperti biasa
        $request->authenticate();

        // 2. Jika email dan password BENAR, sekarang cek status approval
        $user = Auth::user();

        if (!$user->is_approved) {
            // 3. Jika user BELUM di-approve:
            // Logout user yang baru saja berhasil login
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Kembalikan ke halaman login dengan pesan error custom
            return back()->withErrors([
                'email' => 'Your account is not approved yet. Please wait for admin approval.',
            ]);
        }

        // 4. Jika user SUDAH di-approve, lanjutkan proses login seperti biasa
        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
