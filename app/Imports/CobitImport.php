<?php
namespace App\Imports;

use App\Models\CobitItem;
use App\Models\Jawaban;
use App\Models\Kategori;
use App\Models\Level;
use App\Models\Quisioner;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;

class CobitImport implements ToCollection
{
    public function collection(Collection $collection)
    {
        $userId = Auth::id();

        foreach ($collection as $index => $row) {
            // Skip header row (first row, or if contains non-numeric level)
            if ($index === 0 && strtolower(trim($row[0])) === 'nama_item') continue;
            if ($row->filter()->isEmpty()) continue;

            // 1. Find or Create CobitItem
            $cobit = CobitItem::firstOrCreate(
                ['nama_item' => $row[0]],
                ['deskripsi' => $row[1] ?? '-']
            );

            // 2. Find or Create Kategori for this CobitItem
            $kategori = Kategori::firstOrCreate(
                [
                    'nama' => $row[2],
                    'cobit_item_id' => $cobit->id,
                ]
            );

            // 3. Always create new Level
            $level = Level::create([
                'nama_level' => 'Level ' . $row[3],
                'level_number' => $row[3],
                'kategori_id' => $kategori->id,
            ]);

            // 4. Create Quisioner
            $quisioner = Quisioner::create([
                'pertanyaan' => $row[4],
                'level_id' => $level->id,
            ]);

            // 5. Create default Jawaban (N, P, L, F)
            foreach (['N', 'P', 'L', 'F'] as $opt) {
                Jawaban::create([
                    'jawaban' => $opt,
                    'quisioner_id' => $quisioner->id,
                    'user_id' => $userId,
                    'level_id' => $level->id,
                ]);
            }
        }
    }
}
