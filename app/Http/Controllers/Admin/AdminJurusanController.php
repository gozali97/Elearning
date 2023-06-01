<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminJurusanController extends Controller
{
    public function index(){

        $data = Jurusan::all();
        return view('admin.jurusan.index', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $validasi = Validator::make($request->all(), [
                'nama' => 'required',
            ], [
                'nama.required' => 'Kolom nama jurusan harus diisi.',

            ]);

            if ($validasi->fails()) {
                return back()->withErrors($validasi)->withInput();
            }

            Jurusan::create([
                'nama_jurusan' => $request->nama,
            ]);

            return redirect()->route('admin.jurusan.index')->with('success', 'Data jurusan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data jurusan.');
        }
    }

    public function update(Request $request, $id)
    {
        $validasi = Validator::make($request->all(), [
            'nama' => 'required',
        ], [
            'nama.required' => 'Kolom nama jurusan harus diisi.',

        ]);

        if ($validasi->fails()) {
            return back()->withErrors($validasi)->withInput();
        }
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
