<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use App\Models\Level;
use App\Models\Quisioner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JawabanController extends Controller
{
    public function store(Request $request, $levelId)
{
    // Validasi input jawaban
    $validated = $request->validate([
        'jawaban.*' => 'required|in:N,P,L,F',  // Pilihan jawaban harus salah satu dari N, P, L, F
    ]);

    $userId = Auth::id();

    // Menyimpan atau update jawaban ke database
    foreach ($validated['jawaban'] as $quisionerId => $jawaban) {
        // Cek jawaban user yang sudah ada untuk quisioner & level ini
        $existingJawaban = Jawaban::where('user_id', $userId)
            ->where('quisioner_id', $quisionerId)
            ->where('level_id', $levelId)
            ->first();

        if ($existingJawaban) {
            // Update jawaban lama
            $existingJawaban->update(['jawaban' => $jawaban]);
        } else {
            // Buat jawaban baru
            Jawaban::create([
                'jawaban' => $jawaban,
                'quisioner_id' => $quisionerId,
                'user_id' => $userId,
                'level_id' => $levelId,
            ]);
        }
    }



    // Ambil level beserta kategori & cobitItem
    $level = Level::with(['kategori.cobitItem'])->findOrFail($levelId);

    // Cek apakah semua jawaban quisioner level ini adalah F
    $allAnsweredF = Jawaban::whereIn('quisioner_id', $level->quisioners->pluck('id'))
                    ->where('user_id', $userId)
                    ->where('jawaban', 'F')
                    ->count() == $level->quisioners->count();

                    if ($allAnsweredF) {
                        // Kalau ada level berikutnya, tapi kita tetap kembali ke list level dulu
                        return redirect()->route('audit.showLevels', [
                            'cobitItem' => $level->kategori->cobitItem->id,
                            'kategori' => $level->kategori->id,
                        ]);
                    } else {
                        return redirect()->route('audit.showLevels', [
                            'cobitItem' => $level->kategori->cobitItem->id,
                            'kategori' => $level->kategori->id,
                        ]);
                    }

}



}
