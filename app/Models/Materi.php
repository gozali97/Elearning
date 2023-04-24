<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;
    protected $table = 'materi';
    protected $primaryKey = 'id_materi';

    protected $guarded = [];

    public function mapel()
    {
        return $this->belongsTo(MataPelajaran::class);
    }

    public function jadwal()
    {
        return $this->belongsTo(JadwalPelajaran::class);
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }
}
