<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    protected $table = 'guru';
    protected $guarded = [];
    protected $primaryKey = 'nip';
    public $incrementing = false;
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function jadwal()
    {
        return $this->hasOne(JadwalPelajaran::class);
    }

    public function komentar()
    {
        return $this->hasMany(Komentar::class);
    }
}
