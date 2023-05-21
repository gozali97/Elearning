<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\DiskusiMateri;
use App\Models\DiskusiMateriPenerima;
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
        $validatedData = $request->validate([
            'materi_id' => 'required',
            'sender_id' => 'required',
            'isi_pesan' => 'required',
        ]);

        $materiId = $validatedData['materi_id'];
        $senderId = $validatedData['sender_id'];
        $isiPesan = $validatedData['isi_pesan'];

        // Simpan pesan ke tabel diskusi_materi
        $pesan = DiskusiMateri::create([
            'materi_id' => $materiId,
            'sender_id' => $senderId,
            'isi_pesan' => $isiPesan,
            'receiver_role' => 'student', // Pesan ditujukan kepada murid
        ]);

        // Dapatkan ID semua murid yang terkait dengan materi
        $receiverIds = Materi::query()
            ->join('jadwal_pelajaran', 'jadwal_pelajaran.kode_jadwal', 'materi.jadwal_id')
            ->join('kelas', 'kelas.id_kelas', 'jadwal_pelajaran.kelas_id')
            ->join('siswa', 'siswa.kelas_id', 'kelas.id_kelas')
            ->join('users', 'users.email', 'siswa.email')
            ->where('id_materi', $materiId)
            ->pluck('users.id');

        // Simpan entri penerima untuk setiap murid
        foreach ($receiverIds as $receiverId) {
            DiskusiMateriPenerima::create([
                'diskusi_materi_id' => $pesan->id,
                'receiver_id' => $receiverId,
            ]);
        }

        return redirect()->back()->with('success', 'Pesan berhasil dikirim ke seluruh murid.');
    }
}
