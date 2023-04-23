<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalSiswa extends Model
{
    use HasFactory;
    protected $table = 'jadwal_siswa';
    protected $primaryKey = 'kode_mapel';

    public $incrementing = false;

    protected $guarded = [];
}
