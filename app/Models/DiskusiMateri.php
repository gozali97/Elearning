<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiskusiMateri extends Model
{
    use HasFactory;
    protected $table = 'diskusi_materi';
    protected $guarded = [];
    protected $primaryKey = 'id_diskusi';

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function materi()
    {
        return $this->belongsTo(Materi::class);
    }
}
