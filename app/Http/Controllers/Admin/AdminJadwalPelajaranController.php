<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\JadwalPelajaran;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminJadwalPelajaranController extends Controller
{
    public function index(){

        $data = JadwalPelajaran::query()
        ->join('mata_pelajarans', 'mata_pelajarans.kode_mapel', 'jadwal_pelajaran.mapel_id')
        ->join('kelas', 'kelas.id_kelas', 'jadwal_pelajaran.kelas_id')
        ->join('guru', 'guru.nip', 'jadwal_pelajaran.guru_id')
        ->join('users', 'users.email', 'guru.email')
        ->get();

        $kelas = Kelas::all();
        $mapel = MataPelajaran::all();
        $guru = Guru::query()
        ->join('users', 'users.email', 'guru.email')
        ->get();

        return view('admin.jadwal.index', compact('data', 'kelas', 'mapel', 'guru'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'kelas' => 'required',
                'guru' => 'required',
                'mapel' => 'required',
                'jam' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            $lastData = JadwalPelajaran::orderBy('kode_jadwal', 'desc')->first();

            if ($lastData) {
                $nomorUrutan = intval(substr($lastData->kode_jadwal, 3)) + 1;
                $kode = 'JP' . str_pad($nomorUrutan, 3, '0', STR_PAD_LEFT);
            } else {
                $kode = 'JP001';
            }


            JadwalPelajaran::create([
                'kode_jadwal' => $kode,
                'kelas_id' => $request->kelas,
                'mapel_id' => $request->mapel,
                'guru_id' => $request->guru,
                'jam_pelajaran' => $request->jam,
            ]);

            return redirect()->route('admin.jadwal.index')->with('success', 'Data Jadwal Pelajaran berhasil ditambahkan.');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data jadwal pelajaran.', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $data = JadwalPelajaran::where('kode_jadwal', $id)->first();
        $data->kelas_id = $request->kelas;
        $data->mapel_id = $request->mapel;
        $data->guru_id = $request->guru;
        $data->jam_pelajaran = $request->jam;
        $data->save();

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal Pelajaran berhasil diupdate.');
    }

    public function destroy($id)
    {
        $data = JadwalPelajaran::where('kode_jadwal', $id)->first();

        if (!$data) {
            return redirect()->back()->with('error', 'Jadwal tidak ditemukan.');
        }

        $data->delete();

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal Pelajaran berhasil dihapus.');
    }
}
