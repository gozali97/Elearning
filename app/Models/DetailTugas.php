<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTugas extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $tabel = 'detail_tugas';
    protected $primaryKey = 'id_detail_tugas';

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function komentar()
    {
        return $this->hasMany(Komentar::class);
    }
}
