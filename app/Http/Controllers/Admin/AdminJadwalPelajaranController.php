<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use Illuminate\Http\Request;

class AdminJadwalPelajaranController extends Controller
{
    public function index(){

        $data = JadwalPelajaran::query()
        ->join('mata_pelajarans', 'mata_pelajarans.id_mapel', 'jadwal_pelajarans.mapel_id')
        ->join('kelas', 'kelas.id_kelas', 'jadwal_pelajarans.kelas_id')
        ->join('gurus', 'gurus.id_guru', 'jadwal_pelajarans.guru_id')
        ->get();
        return view('admin.jurusan.index', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            // dd($request->all());
            $request->validate([
                'nama' => 'required|max:255',
            ]);

            JadwalPelajaran::create([
                'nama_jurusan' => $request->nama,
            ]);

            return redirect()->route('admin.jurusan.index')->with('success', 'Data jurusan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data jurusan.');
        }
    }

    public function update(Request $request, $id)
    {
        $data = Jurusan::where('id_jurusan', $id)->first();
        $data->nama_jurusan = $request->nama;
        $data->save();

        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil diupdate.');
    }

    public function destroy($id)
    {
        $data = Jurusan::where('id_jurusan', $id)->first();

        // dd($data);
        if (!$data) {
            return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
        }

        $data->delete();

        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil dihapus.');
    }
}
