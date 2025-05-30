<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\CobitItem;
use Illuminate\Http\Request;

class KategoriController extends Controller // Ganti nama controller jika berbeda
{
    public function index(Request $request)
    {
        // Ambil semua Cobit Item untuk pilihan filter dropdown
        $cobitItems = CobitItem::orderBy('nama_item')->get(); // Atau field nama yang sesuai

        // Ambil ID Cobit Item yang dipilih dari request (jika ada)
        $selectedCobitItemId = $request->query('cobit_item_id');

        // Query dasar untuk mengambil kategori, beserta relasi cobitItem
        $kategorisQuery = Kategori::with('cobitItem');

        // Jika ada Cobit Item yang dipilih, filter berdasarkan itu
        if ($selectedCobitItemId) {
            $kategorisQuery->where('cobit_item_id', $selectedCobitItemId);
        }

        // Anda bisa menambahkan orderBy di sini jika perlu
        $kategorisQuery->orderBy(
            CobitItem::select('nama_item') // Ganti 'nama_item' jika berbeda
                ->whereColumn('cobit_items.id', 'kategoris.cobit_item_id')
        )->orderBy('kategoris.nama', 'asc');


        // Ambil data kategori dengan paginasi
        // Ganti '15' dengan jumlah item per halaman yang Anda inginkan
        $kategoris = $kategorisQuery->paginate(15)->appends($request->query());

        // Kirim data ke view
        // Pastikan nama view 'admin.kategoris.index' atau yang sesuai dengan lokasi file Blade Anda
        return view('kategori.index', [ // Ganti dengan path view Anda yang benar
            'kategoris' => $kategoris,
            'cobitItems' => $cobitItems, // Untuk mengisi dropdown filter
            'selectedCobitItemId' => $selectedCobitItemId, // Untuk menandai opsi yang dipilih
        ]);
    }


    // Menampilkan form untuk membuat kategori baru
    public function create()
{
    $cobitItems = CobitItem::all(); // Ambil semua data CobitItem
    return view('kategori.create', compact('cobitItems'));
}

    // Menyimpan kategori baru ke database
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'cobit_item_id' => 'required|exists:cobit_items,id',
        ]);

        // Menyimpan kategori baru
        Kategori::create([
            'nama' => $validated['nama'],
            'cobit_item_id' => $validated['cobit_item_id'],
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    // Menampilkan form untuk mengedit kategori
    public function edit($id)
{
    $kategori = Kategori::findOrFail($id);
    $cobitItems = CobitItem::all(); // Ambil semua data CobitItem
    return view('kategori.edit', compact('kategori', 'cobitItems'));
}

    // Mengupdate kategori yang ada di database
    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'cobit_item_id' => 'required|exists:cobit_items,id',
        ]);

        $kategori = Kategori::findOrFail($id); // Mencari data berdasarkan ID

        // Mengupdate data kategori
        $kategori->update([
            'nama' => $validated['nama'],
            'cobit_item_id' => $validated['cobit_item_id'],
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    // Menghapus kategori dari database
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
