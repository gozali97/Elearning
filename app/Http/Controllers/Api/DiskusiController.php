<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotifikasiController;
use App\Models\DiskusiMateri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiskusiController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('materi_id');
        $idMessage = $request->input('message_id');

        $data = DiskusiMateri::query()
            ->orderBy('diskusi_materi.id_diskusi', 'asc')->take(20)
            ->leftjoin('users', 'users.id', 'diskusi_materi.sender_id')
            ->select('diskusi_materi.*', 'users.email', 'users.name')
            ->where([
                ['diskusi_materi.materi_id', $id],
                ['id_diskusi', '>', $idMessage]])
            ->get();

        if ($data) {
            return $this->success($data);
        } else {
            return $this->error('Terjadi kesalahan');
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'materi_id' => 'required',
            'isi_pesan' => 'required',
            'jadwal_id' => 'required',
            'nama_materi' => 'required'
        ]);
        
        $user = Auth::user();

        $materi_id = $validatedData['materi_id'];
        $isiPesan = $validatedData['isi_pesan'];

        $balasan = DiskusiMateri::create([
            'materi_id' => $materi_id,
            'sender_id' => $user->id,
            'isi_pesan' => $isiPesan,
            'receiver_role' => '2'
        ]);

        if ($balasan) {
            $notifikasi = new NotifikasiController();
            
            if ($notifikasi->setNotifikasiByTopic("Pesan Baru pada diskusi materi '" . $request->nama_materi . "'", '~ ' . $user->name . ' '  . $request->isi_pesan, $request->jadwal_id)['terkirim']) {
                $notif = ' Notif berhasil dikirim.';
            } else {
                $notif = ' Notif gagal dikirim.';
            }

            return $this->success('Pesan berhasil dibalas.' . $notif);
        } else {
            return $this->error('Data tidak ditemukan');
        }
    }

    public function success($data, $code = "200")
    {
        return response()->json([
            'status' => 'Berhasil',
            'code' => $code,
            'data' => $data
        ]);
    }

    public function error($message)
    {
        return response()->json([
            'status' => 'Gagal',
            'code' => 400,
            'message' => $message
        ], 400);
    }
}