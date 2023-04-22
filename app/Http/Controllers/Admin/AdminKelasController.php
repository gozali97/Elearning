<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use Illuminate\Http\Request;

class AdminKelasController extends Controller
{
    public function index(){

        $data = Kelas::query()
        ->join('jurusans', 'jurusans.id_jurusan', 'kelas.jurusan_id')
        ->get();

        $jurusan = Jurusan::all();
        return view('admin.kelas.index', compact('data', 'jurusan'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|max:255',
            ]);

            Kelas::create([
                'nama_kelas' => $request->nama,
                'jurusan_id' => $request->jurusan,
            ]);

            return redirect()->route('admin.kelas.index')->with('success', 'Data kelas berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data kelas.');
        }
    }

    public function update(Request $request, $id)
    {
        $data = Kelas::where('id_kelas', $id)->first();
        $data->nama_kelas = $request->nama;
        $data->jurusan_id = $request->jurusan;
        $data->save();

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil diupdate.');
    }

    public function destroy($id)
    {
        $data = Kelas::where('id_kelas', $id)->first();

        if (!$data) {
            return redirect()->back()->with('error', 'Kelas tidak ditemukan.');
        }

        $data->delete();

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
