<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiskusiMateriPenerima extends Model
{
    use HasFactory;
    protected $table = 'diskusi_materi_penerima';
    protected $guarded = [];
    protected $primaryKey = 'id_diskusi_penerima';
}
