<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetailTugas;
use App\Models\JadwalPelajaran;
use App\Models\Materi;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiswaTugasController extends Controller
{

    public function index(Request $request)
    {
        $nis = $request->input('nis');

        $data = JadwalPelajaran::query()
            ->select('jadwal_pelajaran.kode_jadwal', 'kelas.nama_kelas', 'mata_pelajarans.nama_mapel', 'users.name')
            ->join('kelas', 'kelas.id_kelas', 'jadwal_pelajaran.kelas_id')
            ->join('guru', 'guru.nip', 'jadwal_pelajaran.guru_id')
            ->join('mata_pelajarans', 'mata_pelajarans.kode_mapel', 'jadwal_pelajaran.mapel_id')
            ->join('siswa', 'siswa.kelas_id', 'kelas.id_kelas')
            ->join('users', 'users.email', 'guru.email')
            ->where('siswa.nis', $nis)
            ->get();

        if ($data) {
            return $this->success($data);
        } else {
            return $this->error('Data tidak ditemukan');
        }
    }

    public function viewMateri(Request $request)
    {
        $id = $request->input('jadwal_id');

        $data = Materi::query()
            ->leftJoin('tugas', 'tugas.materi_id', 'materi.id_materi')
            ->select('materi.*', 'tugas.id_tugas')
            ->where('materi.jadwal_id', $id)
            ->get();

        if ($data) {
            return $this->success($data);
        } else {
            return $this->error('Data tidak ditemukan');
        }
    }

    public function viewTugas(Request $request)
    {
        $id = $request->input('tugas_id');
        $siswa_id = $request->input('siswa_id');

        $data = Tugas::where('id_tugas', $id)->first();

        if ($data) {
            $data['detail_tugas'] = DetailTugas::where([
                ['siswa_id', $siswa_id],
                ['tugas_id', $data->id_tugas],
            ])->first();
            return $this->success($data);
        } else {
            return $this->error('Data tidak ditemukan');
        }
    }

    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'tugas_id' => 'required',
            'siswa_id' => 'required',
            'file' => 'required|mimes:pdf|max:10000',
        ]);

        if ($validasi->fails()) {
            $val = $validasi->errors()->all();
            return $this->error($val[0]);
        }

        $file  = $request->siswa_id . '-' . time() .  '.' . $request->file->extension();
        $path       = $request->file('file')->move('assets/tugas-siswa', $file);

        $data = DetailTugas::create([
            'tugas_id' => $request->tugas_id,
            'siswa_id' => $request->siswa_id,
            'file' => $file,
            'nilai' => 0,
            'submit' => date('Y-m-d H:m:s')
        ]);

        if ($data->save()) {
            return $this->success($data);
        } else {
            return $this->error("Gagal menyimpan tugas");
        }
    }

    public function update(Request $request)
    {
        $id = $request->input('detail_id');

        $data = DetailTugas::where('id_detail_tugas', $id)->first();

        if ($request->hasFile('file')) {

            if (file_exists(public_path('assets/tugas-siswa/' . $data->file))) {
                unlink(public_path('assets/tugas-siswa/' . $data->file));
            }

            $pdf  = $request->siswa_id . '-' . time() .  '.' . $request->file->extension();
            $path       = $request->file('file')->move('assets/tugas-siswa', $pdf);
            $data->file = $pdf;
        }

        if ($data->save()) {
            return $this->success($data);
        } else {
            return $this->error("Gagal menyimpan tugas");
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