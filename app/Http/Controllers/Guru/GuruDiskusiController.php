<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\DiskusiMateri;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruDiskusiController extends Controller
{
    public function index($id)
    {
        $materi = Materi::query()
            ->join('jadwal_pelajaran', 'jadwal_pelajaran.kode_jadwal', 'materi.jadwal_id')
            ->join('guru', 'guru.nip', 'jadwal_pelajaran.guru_id')
            ->join('users', 'users.email', 'guru.email')
            ->where('id_materi', $id)
            ->first();
        // dd($materi);

        return view('guru.mapel.diskusi.index', compact('materi'));
    }

    public function store(Request $request)
    {
        $forumDiskusi = new DiskusiMateri();
        $forumDiskusi->siswa_id = Auth::user()->siswa->id;
        $forumDiskusi->guru_id = $request->guru_id;
        $forumDiskusi->materi_id = $request->materi_id;
        $forumDiskusi->isi_pesan = $request->isi_pesan;
        $forumDiskusi->save();

        return redirect()->back()->with('success', 'Pesan berhasil ditambahkan.');
    }
}
