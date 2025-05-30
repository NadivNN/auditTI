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

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = true;
        $user->save();

        // (Next step nanti: kirim notifikasi email di sini)

        return redirect()->route('admin.approvals')->with('success', 'User approved successfully.');
    }
}
