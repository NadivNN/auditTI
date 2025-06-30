<?php

namespace App\Services;

use App\Models\User;
use App\Models\CobitItem;
use App\Models\Jawaban;
use Illuminate\Support\Facades\Cache;

class UserProgressService
{
    /**
     * Menghitung atau mengambil data progres dari cache untuk user tertentu.
     */
    public function getProgressData(User $user): array
    {
        $cacheKey = 'progress_data_user_' . $user->id;

        // Ambil dari cache jika ada, jika tidak, hitung dan simpan ke cache selama 10 menit
        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($user) {
            return $this->calculateDataFor($user);
        });
    }

    /**
     * Logika utama untuk kalkulasi progres.
     * Dibuat private agar hanya bisa dipanggil dari dalam service ini.
     */
    private function calculateDataFor(User $user): array
    {
        // Ambil semua jawaban user dan kelompokkan berdasarkan level_id
        $userAnswersByLevel = Jawaban::where('user_id', $user->id)
            ->get()
            ->groupBy('level_id');

        $cobitItems = CobitItem::with(['kategoris.levels.quisioners'])
            ->where('is_visible', true)
            ->get();

        // Gunakan ->map() agar kode lebih ringkas
        return $cobitItems->map(function ($item) use ($userAnswersByLevel) {
            $kategoriData = $item->kategoris->map(function ($kategori) use ($userAnswersByLevel) {
                $levelData = $kategori->levels->map(function ($level) use ($userAnswersByLevel) {
                    $totalQuisioners = $level->quisioners->count();
                    $answeredQuisioners = $userAnswersByLevel[$level->id]
                        ? $userAnswersByLevel[$level->id]->pluck('quisioner_id')->unique()->count()
                        : 0;

                    $isCompleted = ($totalQuisioners > 0 && $answeredQuisioners >= $totalQuisioners);

                    return [
                        'id' => $level->id,
                        'nama_level' => $level->nama_level,
                        'is_completed' => $isCompleted,
                        'percentage' => ($totalQuisioners > 0) ? round(($answeredQuisioners / $totalQuisioners) * 100) : 0,
                    ];
                });

                return [
                    'nama_kategori' => $kategori->nama_kategori,
                    'completed_levels_in_kategori' => $levelData->where('is_completed', true)->count(),
                    'total_levels_in_kategori' => $levelData->count(),
                    'levels' => $levelData->all(),
                ];
            });

            return [
                'nama_item' => $item->nama_item,
                'completed_levels_in_item' => $kategoriData->sum('completed_levels_in_kategori'),
                'total_levels_in_item' => $kategoriData->sum('total_levels_in_kategori'),
                'kategoris' => $kategoriData->all(),
            ];
        })->all();
    }

    /**
     * Method untuk membersihkan cache user tertentu.
     * Panggil ini setiap kali user berhasil submit jawaban baru.
     */
    public static function clearCache(User $user): void
    {
        Cache::forget('progress_data_user_' . $user->id);
    }
}
