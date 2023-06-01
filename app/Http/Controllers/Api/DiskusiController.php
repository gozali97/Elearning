<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DiskusiMateri;
use App\Models\DiskusiMateriPenerima;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiskusiController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('materi_id');
        $idMessage = $request->input('message_id');

        $data = DiskusiMateri::query()
            ->orderBy('diskusi_materi.id_diskusi', 'asc')->take(10)
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
            'email' => 'required',
            'materi_id' => 'required',
            'isi_pesan' => 'required',
            'waktu_pesan' => 'required'
        ]);

        $materi_id = $validatedData['materi_id'];
        $isiPesan = $validatedData['isi_pesan'];
        $waktuPesan = $validatedData['waktu_pesan'];

        $sender_id =  User::select('id')
            ->where('email', $validatedData['email'])
            ->first();

        $balasan = DiskusiMateri::create([
            'materi_id' => $materi_id,
            'sender_id' => $sender_id['id'],
            'isi_pesan' => $isiPesan,
            'receiver_role' => '2',
            'created_at' => $waktuPesan,
            'updated_at' => $waktuPesan
        ]);

        if ($balasan) {
            return $this->success('Pesan berhasil dibalas.');
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
