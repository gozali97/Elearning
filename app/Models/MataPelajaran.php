<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;
    protected $table = 'mata_pelajarans';
    protected $primaryKey = 'kode_mapel';

    public $incrementing = false;
    
    protected $guarded = [];

    public function jadwal()
    {
        return $this->hasOne(JadwalPelajaran::class);
    }

    public function materi()
    {
        return $this->hasMany(Materi::class);
    }
}
