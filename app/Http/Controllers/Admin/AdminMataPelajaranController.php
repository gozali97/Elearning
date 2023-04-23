<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminMataPelajaranController extends Controller
{
    public function index(){

        $data = MataPelajaran::all();

        return view('admin.mapel.index', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|max:255',
                'deskripsi' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            $lastData = MataPelajaran::orderBy('kode_mapel', 'desc')->first();

            if ($lastData) {
                $nomorUrutan = intval(substr($lastData->kode_mapel, 3)) + 1;
                $kode = 'MP' . str_pad($nomorUrutan, 3, '0', STR_PAD_LEFT);
            } else {
                $kode = 'MP001';
            }

            MataPelajaran::create([
                'kode_mapel' => $kode,
                'nama_mapel' => $request->nama,
                'deskripsi' => $request->deskripsi,
            ]);

            return redirect()->route('admin.mapel.index')->with('success', 'Data Mata Pelajaran berhasil ditambahkan.');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data mata pelajaran.');
        }
    }

    public function update(Request $request, $id)
    {
        $data = MataPelajaran::where('kode_mapel', $id)->first();
        $data->nama_mapel = $request->nama;
        $data->deskripsi = $request->deskripsi;
        $data->save();

        return redirect()->route('admin.mapel.index')->with('success', 'Mata Pelajaran berhasil diupdate.');
    }

    public function destroy($id)
    {
        $data = MataPelajaran::where('kode_mapel', $id)->first();

        if (!$data) {
            return redirect()->back()->with('error', 'Kelas tidak ditemukan.');
        }

        $data->delete();

        return redirect()->route('admin.mapel.index')->with('success', 'Mata Pelajaran berhasil dihapus.');
    }
}
