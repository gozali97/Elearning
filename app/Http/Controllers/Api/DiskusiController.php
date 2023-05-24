<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DiskusiMateri;
use App\Models\DiskusiMateriPenerima;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiskusiController extends Controller
{
    public function index(Request $request)
    {

        $validatedData = $request->validate([
            'pesan_id' => 'required',
            'isi_pesan' => 'required',
        ]);

        $pesanId = $validatedData['pesan_id'];
        $isiPesan = $validatedData['isi_pesan'];

        // Periksa apakah siswa merupakan penerima pesan
        $receiverId = Auth::id();
        $pesan = DiskusiMateriPenerima::query()
            ->lefJoin('diskusi_materi', 'diskusi_materi.materi_id', 'diskusi_materi_penerima.diskusi_materi_id')
            ->where('diskusi_materi_id', $pesanId)
            ->where('receiver_id', $receiverId)
            ->first();

        if (!$pesan) {
            return response()->json(['error' => 'Anda tidak memiliki izin untuk membalas pesan ini.'], 403);
        }

        // Simpan balasan pesan
        $balasan = DiskusiMateri::create([
            'materi_id' => $pesan->materi_id,
            'sender_id' => $receiverId,
            'isi_pesan' => $isiPesan,
            'receiver_role' => '2',
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
