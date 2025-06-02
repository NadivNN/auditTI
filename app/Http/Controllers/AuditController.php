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
            ->orderBy('level_number', 'asc')
            ->get();

        $levelsWithStatus = collect();
        $prevLevelHasF = true; // Level 1 selalu muncul

        foreach ($levels as $level) {
            $quisionerIds = $level->quisioners()->pluck('id');

            $userAnswers = Jawaban::where('user_id', $userId)
                ->where('level_id', $level->id)
                ->whereIn('quisioner_id', $quisionerIds)
                ->pluck('jawaban');

            // Cek apakah user sudah isi jawaban apapun
            $hasAnyAnswer = $userAnswers->isNotEmpty();

            // Cek apakah jawaban user mengandung "F"
            $hasFAnswer = $userAnswers->contains('F');

            // Cek pengajuan ulang
            $activeRequest = ResubmissionRequest::where('user_id', $userId)
                ->where('level_id', $level->id)
                ->whereIn('status', ['pending', 'approved'])
                ->first();

            // Set flags untuk view
            $level->hasAnswers = $hasAnyAnswer;
            $level->hasFAnswer = $hasFAnswer;
            $level->approvedRequest = optional($activeRequest)->status === 'approved';
            $level->pendingRequest = optional($activeRequest)->status === 'pending';
            $level->canRequestResubmission = $hasAnyAnswer && !$activeRequest;
            $level->unlocked = $prevLevelHasF || $level->approvedRequest;

            // Tampilkan hanya jika level unlocked
            if ($level->unlocked) {
                $levelsWithStatus->push($level);
            }

            // Persiapkan flag untuk level berikutnya
            $prevLevelHasF = $hasFAnswer || $level->approvedRequest;
        }

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
