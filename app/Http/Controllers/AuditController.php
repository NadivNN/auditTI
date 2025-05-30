<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Jawaban;
use App\Models\Kategori;
use App\Models\CobitItem;
// use App\Models\Quisioner; // Tidak digunakan langsung di showLevels
use Illuminate\Http\Request; // Tidak digunakan langsung di showLevels
use App\Models\ResubmissionRequest;
use Illuminate\Support\Facades\Auth;

class AuditController extends Controller
{
    public function index()
    {
        // Ambil hanya cobit items yang visible untuk user
        $cobitItems = CobitItem::where('is_visible', true)->get();
        return view('audit.index', compact('cobitItems'));
    }

    public function showCategories(CobitItem $cobitItem)
    {
        // Mengambil kategori berdasarkan cobit_item_id
        $kategoris = Kategori::where('cobit_item_id', $cobitItem->id)->get();
        return view('audit.categories', compact('kategoris', 'cobitItem'));
    }

    public function showLevels(CobitItem $cobitItem, Kategori $kategori)
    {
        $userId = Auth::id();
        $levels = Level::where('kategori_id', $kategori->id)
                       // ->orderBy('urutan_kolom', 'asc') // Jika ada kolom urutan, aktifkan
                       ->get();

        $levelsWithStatus = $levels->map(function ($level) use ($userId) {
            // 1. Cek apakah user sudah pernah menjawab level ini
            $level->hasAnswers = Jawaban::where('user_id', $userId)
                                        ->where('level_id', $level->id)
                                        ->exists();

            // 2. Cek apakah ada permintaan pengisian ulang yang statusnya 'pending' atau 'approved'
            $activeRequest = ResubmissionRequest::where('user_id', $userId)
                                                ->where('level_id', $level->id)
                                                ->whereIn('status', ['pending', 'approved'])
                                                ->first();

            // 3. Set flag berdasarkan status request
            $level->pendingRequest = $activeRequest && $activeRequest->status == 'pending';
            $level->approvedRequest = $activeRequest && $activeRequest->status == 'approved';
            
            // 4. Tentukan apakah tombol "Ajukan Pengisian Ulang" bisa ditampilkan
            // Bisa diajukan jika: sudah dijawab DAN TIDAK ada request yang statusnya pending ATAU approved
            $level->canRequestResubmission = $level->hasAnswers && !$activeRequest;

            // Untuk Debugging Individual Level (bisa di-uncomment jika dd() di bawah terlalu banyak)
            /*
            dump([
                'level_id' => $level->id,
                'nama_level' => $level->nama_level,
                'hasAnswers' => $level->hasAnswers,
                'activeRequest_status' => $activeRequest ? $activeRequest->status : null,
                'pendingRequest' => $level->pendingRequest,
                'approvedRequest' => $level->approvedRequest,
                'canRequestResubmission' => $level->canRequestResubmission,
            ]);
            */

            return $level;
        });

        // !!! PENTING: HENTIKAN EKSEKUSI DAN TAMPILKAN DATA UNTUK DEBUGGING !!!
        // Periksa output ini di browser Anda.
        // Untuk setiap level, pastikan 'hasAnswers' dan 'canRequestResubmission' memiliki nilai yang Anda harapkan.
        // dd($levelsWithStatus->toArray());

        // Pastikan nama view Anda adalah 'audit.levels' atau sesuaikan
        return view('audit.levels', [
            'cobitItem' => $cobitItem,
            'kategori' => $kategori,
            'levels' => $levelsWithStatus,
        ]);
    }

    public function showQuisioner(CobitItem $cobitItem, Kategori $kategori, Level $level)
    {
        $userId = Auth::id();
        $hasAnswers = Jawaban::where('user_id', $userId)
                              ->where('level_id', $level->id)
                              ->exists();

        if ($hasAnswers) {
            $approvedRequest = ResubmissionRequest::where('user_id', $userId)
                ->where('level_id', $level->id)
                ->where('status', 'approved')
                ->exists();

            if (!$approvedRequest) {
                return redirect()->route('audit.showLevels', ['cobitItem' => $cobitItem->id, 'kategori' => $kategori->id])
                                 ->with('error', 'Anda sudah mengisi kuesioner untuk level ini. Ajukan pengisian ulang jika ingin mengubah.');
            }
        }

        $quisioners = $level->quisioners()->get(); // Asumsi relasi 'quisioners' di model Level

        // Pastikan nama view Anda adalah 'audit.quisioner' atau sesuaikan
        return view('audit.quisioner', [
            'cobitItem' => $cobitItem,
            'kategori' => $kategori,
            'level' => $level,
            'quisioners' => $quisioners,
        ]);
    }
}