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
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate(); // Biarkan Laravel autentikasi biasa

        $request->session()->regenerate();

        // Cek kalau BUKAN admin dan belum approved => logout
        if (Auth::user()->role !== 'admin' && !Auth::user()->approved) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Your account is not approved yet. Please wait for admin approval.',
            ]);
        }


        return redirect()->intended(RouteServiceProvider::redirectTo());

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
