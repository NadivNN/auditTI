<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $table = 'levels';

    // Tambahkan level_number ke dalam array fillable
    protected $fillable = ['nama_level', 'kategori_id', 'level_number'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function quisioners()
    {
        return $this->hasMany(Quisioner::class);
    }
}
