<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CobitItem; // Sesuaikan dengan namespace model Anda
use App\Models\Kategori;   // Sesuaikan dengan namespace model Anda
use App\Models\Level;      // Sesuaikan dengan namespace model Anda
use App\Models\Jawaban; // Sesuaikan dengan namespace model Anda (atau JawabanPengguna)

class UserProgressController extends Controller
{
    /**
     * Menampilkan halaman progres kuesioner pengguna.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $progressData = [];

        // Ambil semua CobitItem, atau bisa juga CobitItem yang relevan untuk pengguna.
        // Eager load relasi untuk optimasi query.
        $cobitItems = CobitItem::with(['kategoris.levels.quisioners'])->get();

        foreach ($cobitItems as $item) {
            $itemData = [
                'nama_item' => $item->nama_item, // Asumsi kolom 'nama_item' di model CobitItem
                'total_levels_in_item' => 0,
                'completed_levels_in_item' => 0,
                'kategoris' => [],
            ];

            $itemTotalLevelsOverall = 0;
            $itemCompletedLevelsOverall = 0;

            foreach ($item->kategoris as $kategori) {
                $kategoriData = [
                    'nama_kategori' => $kategori->nama_kategori, // Asumsi kolom 'nama_kategori' di model Kategori
                    'total_levels_in_kategori' => 0,
                    'completed_levels_in_kategori' => 0,
                    'levels' => [],
                ];

                $kategoriTotalLevels = 0;
                $kategoriCompletedLevels = 0;

                if ($kategori->levels->isNotEmpty()) {
                    foreach ($kategori->levels as $level) {
                        $kategoriTotalLevels++;

                        $totalQuisionersInLevel = $level->quisioners->count();
                        $answeredQuisionersInLevel = 0;

                        if ($totalQuisionersInLevel > 0) {
                            // Hitung pertanyaan yang sudah dijawab oleh user untuk level ini
                            // Pastikan Jawaban memiliki relasi atau cara untuk mengidentifikasi jawaban per level dan user.
                            $answeredQuisionersInLevel = Jawaban::where('user_id', $user->id)
                                ->where('level_id', $level->id)
                                // ->whereNotNull('jawaban') // Opsional: jika ada kolom jawaban dan harus terisi
                                ->distinct('quisioner_id') // Hitung pertanyaan unik yang dijawab
                                ->count();
                        }

                        $isLevelCompleted = ($totalQuisionersInLevel > 0 && $answeredQuisionersInLevel >= $totalQuisionersInLevel);
                        if ($isLevelCompleted) {
                            $kategoriCompletedLevels++;
                        }

                        $percentageForLevel = ($totalQuisionersInLevel > 0)
                            ? round(($answeredQuisionersInLevel / $totalQuisionersInLevel) * 100)
                            : 0;

                        $kategoriData['levels'][] = [
                            'id' => $level->id,
                            'nama_level' => $level->nama_level, // Asumsi kolom 'nama_level' di model Level
                            // 'url' => route('kuesioner.level.show', ['level' => $level->id]), // Ganti 'kuesioner.level.show' dengan nama route Anda
                            'total_quisioners' => $totalQuisionersInLevel,
                            'answered_quisioners' => $answeredQuisionersInLevel,
                            'is_completed' => $isLevelCompleted,
                            'percentage' => $percentageForLevel,
                        ];
                    }
                }

                $kategoriData['total_levels_in_kategori'] = $kategoriTotalLevels;
                $kategoriData['completed_levels_in_kategori'] = $kategoriCompletedLevels;

                $itemTotalLevelsOverall += $kategoriTotalLevels;
                $itemCompletedLevelsOverall += $kategoriCompletedLevels;

                $itemData['kategoris'][] = $kategoriData;
            }

            $itemData['total_levels_in_item'] = $itemTotalLevelsOverall;
            $itemData['completed_levels_in_item'] = $itemCompletedLevelsOverall;

            $progressData[] = $itemData;
        }

        return view('user.progress.index', compact('user', 'progressData'));
        // Pastikan nama view 'progres-kuesioner-saya' sesuai dengan lokasi file blade Anda.
        // Jika file Anda ada di resources/views/user/kuesioner/progres.blade.php, maka viewnya adalah 'user.kuesioner.progres'
    }
}