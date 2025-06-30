<?php

namespace App\Http\Controllers;

use App\Models\CobitItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Penting untuk mendapatkan user yang login

class CobitItemController extends Controller
{
    /**
     * Menampilkan daftar domain Cobit yang bisa diaudit oleh pengguna.
     * Hanya menampilkan item yang 'is_visible'.
     */
    public function index()
    {
        // Pastikan ada pengguna yang login untuk memeriksa status penyelesaian
        if (!Auth::check()) {
            // Jika tidak ada user, redirect ke login atau tampilkan error
            return redirect()->route('login')->with('error', 'Anda harus login untuk mengakses halaman ini.');
        }

        // Ambil semua item Cobit yang ditandai 'visible'
        // Untuk halaman admin, Anda mungkin ingin menggunakan CobitItem::all()
        $cobitItems = CobitItem::where('is_visible', true)->get();

        // Kirim data ke view.
        // Pengecekan status 'isCompletedByUser' akan dilakukan di dalam file Blade
        // untuk menjaga controller tetap bersih.
        return view('cobititem.index', compact('cobitItems'));
    }

    // ... (method create, store, edit, update, destroy tetap sama) ...

    public function create()
    {
        return view('cobititem.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_item' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        CobitItem::create([
            'nama_item' => $validated['nama_item'],
            'deskripsi' => $validated['deskripsi'],
        ]);

        return redirect()->route('cobititem.index')->with('success', 'CobitItem berhasil dibuat!');
    }

    public function edit($id)
    {
        $cobitItem = CobitItem::findOrFail($id);
        return view('cobititem.edit', compact('cobitItem'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_item' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'is_visible' => 'nullable|boolean',
        ]);

        $cobitItem = CobitItem::findOrFail($id);
        $cobitItem->nama_item = $request->nama_item;
        $cobitItem->deskripsi = $request->deskripsi;
        $cobitItem->is_visible = $request->input('is_visible', false); // Cara lebih aman
        $cobitItem->save();

        return redirect()->route('cobititem.index')->with('success', 'Cobit Item updated successfully.');
    }

    public function destroy($id)
    {
        $cobitItem = CobitItem::findOrFail($id);
        $cobitItem->delete();

        return redirect()->route('cobititem.index')->with('success', 'CobitItem berhasil dihapus!');
    }
}
