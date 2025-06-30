<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserApprovalController extends Controller
{
    public function index()
    {
        // Ambil semua user yang belum di-approve
        $pendingUsers = User::where('is_approved', false)->get();
        return view('admin.approvals.index', compact('pendingUsers'));
    }

    public function approve(User $user)
{
    if (!$user->is_approved) {
        $user->is_approved = true;
        $user->email_verified_at = now(); // <-- TAMBAHKAN BARIS INI
        $user->save();
    }

    return redirect()->route('admin.approvals.index')->with('success', 'User ' . $user->name . ' has been approved.');
}
}
