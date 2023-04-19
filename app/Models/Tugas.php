<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    public function materi()
    {
        return $this->belongsTo(Materi::class);
    }

    public function detailTugas()
    {
        return $this->hasMany(DetailTugas::class);
    }
}
