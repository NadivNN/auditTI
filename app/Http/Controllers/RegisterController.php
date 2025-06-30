<?php

namespace App\Http\Controllers;

use App\Mail\NewUserForApproval;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail; // Pastikan ini di-import
use Illuminate\Support\Facades\Log;  // Import Log untuk catatan

class RegisterController extends Controller
{
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'approved' => 0,
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

        try {
            Mail::to(env('ADMIN_EMAIL_ADDRESS'))->send(new NewUserForApproval($user));
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email approval: ' . $e->getMessage());
        }

        return redirect()->route('registration.pending'); // Pastikan nama route ini benar
    }
}
