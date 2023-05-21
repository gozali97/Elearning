<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function index(Request $request)
    {

        $email = $request->input('email');

        $data = User::query()
            ->join('siswa', 'siswa.email', 'users.email')
            ->join('kelas', 'kelas.id_kelas', 'siswa.kelas_id')
            ->join('jurusans', 'jurusans.id_jurusan', 'siswa.jurusan_id')
            ->where('users.email', $email)
            ->first();


        if ($data) {
            return $this->success($data);
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
