<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    use HasFactory;

    protected $fillable = ['jawaban', 'quisioner_id', 'user_id', 'level_id'];  // Menambahkan level_id ke fillable

    // Relasi ke Quisioner
    public function quisioner()
    {
        return $this->belongsTo(Quisioner::class);
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Level
    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
