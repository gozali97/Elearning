<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\SiswaImport;
use App\Models\Jurusan;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class AdminSiswaController extends Controller
{
    public function index()
    {

        $data = Siswa::query()
                ->join('users', 'users.email', 'siswa.email')
                ->get();

        return view('admin.siswa.index', compact('data'));
    }

    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'nama' => 'required|max:255',
                'email' => 'required',
                'no_hp' => 'required',
                'gender' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            $gambar  = time() . 'siswa' . '.' . $request->gambar->extension();
            $path       = $request->file('gambar')->move('assets/img', $gambar);

            DB::beginTransaction();

            $user = new User();
            $user->name = $request->nama;
            $user->gambar = $gambar;
            $user->role_id = 3;
            $user->email = $request->email;
            $user->password = Hash::make('12345678');

            if ($user->save()) {


                $lastData = Siswa::orderBy('nis', 'desc')->first();

                if ($lastData) {
                    $nomorUrutan = intval(substr($lastData->id_siswa, 3)) + 1;
                    $nis = 'SA' . str_pad($nomorUrutan, 3, '0', STR_PAD_LEFT);
                } else {
                    $nis = 'SA001';
                }

                Siswa::create([
                    'nis' => $nis,
                    'email' =>  $user->email,
                    'kelas_id' =>  $user->kelas,
                    'jurusan_id' =>   $request->jurusan,
                    'no_hp' =>   $request->no_hp,
                    'alamat' => $request->alamat,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.manageSiswa.index')->with('success', 'Data Siswa berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data siswa.');
        }
    }

    public function importSiswa(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'excel_file' => 'required|mimes:xlsx,xls',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            $file = $request->file('excel_file');

            Excel::import(new SiswaImport, $file);

            return redirect()->route('admin.manageSiswa.index')->with('success', 'Data Siswa berhasil diimport.');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimport data siswa.');
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
