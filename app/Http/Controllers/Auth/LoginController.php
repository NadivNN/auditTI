<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    protected function authenticated(Request $request, $user)
    {
        // If the user is not approved, log them out and redirect to the login page with an error message
        if ($user->approved == 0) {
            auth()->logout();
            return redirect()->route('login')->withErrors(['email' => 'Your account is not approved yet. Please wait for approval.']);
        }

        return redirect()->intended($this->redirectPath());
    }

    public function login(Request $request)
    {
        // Validate the login form data
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Check if the user is approved before logging in
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // If the user is not approved, log them out and redirect to the login page
            if ($user->approved == 0) {
                Auth::logout();
                return redirect()->route('login')->withErrors(['email' => 'Your account is not approved yet.']);
            }

            return redirect()->intended($this->redirectPath());
        }

        return redirect()->route('login')->withErrors(['email' => 'Invalid login credentials.']);
    }
}

