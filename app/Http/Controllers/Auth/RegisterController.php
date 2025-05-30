<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'approved' => 0, // Set approved to 0 (pending approval)
        ]);
    }

    public function register(Request $request)
    {
        // Validate the registration form data
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Create a new user with approved = 0
        $user = $this->create($validated);

        // Redirect to login page with a success message
        return redirect()->route(route: 'login')->with('status', 'Registration successful! Please wait for admin approval.');
    }
}
