<?php

namespace App\Http\Controllers;

use App\Models\CobitItem;
use Illuminate\Http\Request;

class CobitItemController extends Controller
{
    public function index()
{
    // Ambil semua, tanpa filter is_visible
    $cobitItems = CobitItem::all();

    return view('cobititem.index', compact('cobitItems'));
}



    // Menampilkan form untuk membuat CobitItem
    public function create()
    {
        return view('cobititem.create');
    }

    // Menyimpan data CobitItem ke database
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_item' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        // Menyimpan data
        CobitItem::create([
            'nama_item' => $validated['nama_item'],
            'deskripsi' => $validated['deskripsi'],
        ]);

        // Mengarahkan ke halaman yang diinginkan setelah data disimpan
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
    $cobitItem->is_visible = $request->has('is_visible') ? $request->is_visible : false;
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
