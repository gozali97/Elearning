<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\DiskusiMateri;
use App\Models\DiskusiMateriPenerima;
use App\Models\Materi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        return view('guru.mapel.diskusi.index', compact('materi'));
    }

    public function send(Request $request)
    {
        try {

            DB::beginTransaction();
            // dd($request->all());
            $validatedData = $request->validate([
                'materi_id' => 'required',
                'sender_id' => 'required',
                'isi_pesan' => 'required',
                'kelas_id' => 'required',
            ]);

            $materiId = $validatedData['materi_id'];
            $kelasiId = $validatedData['kelas_id'];
            $senderId = $validatedData['sender_id'];
            $isiPesan = $validatedData['isi_pesan'];

            $pesan = DiskusiMateri::create([
                'materi_id' => $materiId,
                'sender_id' => $senderId,
                'isi_pesan' => $isiPesan,
                'receiver_role' => '3',
            ]);
            $receiverIds = User::query()
                ->join('siswa', 'siswa.email', 'users.email')
                ->join('kelas', 'kelas.id_kelas', 'siswa.kelas_id')
                ->join('jadwal_pelajaran', 'jadwal_pelajaran.kelas_id', 'kelas.id_kelas')
                ->join('materi', 'materi.jadwal_id', 'jadwal_pelajaran.kode_jadwal')
                ->where('materi.id_materi', $materiId)
                ->where('siswa.kelas_id', $kelasiId)
                ->where('role_id', 3)
                ->pluck('users.id');

            foreach ($receiverIds as $receiverId) {
                DiskusiMateriPenerima::create([
                    'diskusi_materi_id' => $pesan->materi_id,
                    'receiver_id' => $receiverId,
                ]);
            }
            DB::commit();
            return redirect()->back()->with('success', 'Pesan berhasil dikirim ke seluruh murid.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data tugas.' . $e->getMessage());
        }
    }

    public function getAllMessages($materi_id)
    {
        try {
            $userId = Auth::user()->id;

            $receivedMessages = DiskusiMateri::query()
                ->where('materi_id', $materi_id)
                ->where('receiver_role', 2)
                ->get();
            $sentMessages = DiskusiMateri::query()
                ->where('sender_id', $userId)
                ->where('materi_id', $materi_id)
                ->get();

            return response()->json([
                'sentMessages' => $sentMessages,
                'receivedMessages' => $receivedMessages
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat mengambil pesan.'], 500);
        }
    }
}
