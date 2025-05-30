<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CobitItem extends Model
{
    use HasFactory;
    protected $fillable = ['nama_item', 'deskripsi', 'is_visible'];

    public function kategoris()
    {
        return $this->hasMany(Kategori::class);
    }
}
