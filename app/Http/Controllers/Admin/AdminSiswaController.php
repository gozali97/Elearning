<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\SiswaImport;
use App\Models\Jurusan;
use App\Models\Kelas;
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

        $kelas = Kelas::all();
        $jurusan = Jurusan::all();

        return view('admin.siswa.index', compact('data','kelas', 'jurusan'));
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

                while (Siswa::where('nis', $nis)->exists()) {
                    $nomorUrutan++;
                    $nis = 'SA' . str_pad($nomorUrutan, 3, '0', STR_PAD_LEFT);
                }

                Siswa::create([
                    'nis' => $nis,
                    'email' =>  $user->email,
                    'jenis_kelamin' =>   $request->gender,
                    'kelas_id' =>  $user->kelas,
                    'jurusan_id' =>   $request->jurusan,
                    'no_hp' =>   $request->no_hp,
                    'alamat' => $request->alamat,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.manageSiswa.index')->with('success', 'Data Siswa berhasil ditambahkan.');
        } catch (\Exception $e) {
            dd($e);
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
        try {

            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'nama' => 'required|max:255',
                'email' => 'required',
                'no_hp' => 'required',
                'gender' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            $data = User::where('id', $id)->first();

            if ($request->hasFile('gambar')) {

                if ($data->gambar !== null && file_exists(public_path('/assets/img/' . $data->gambar))) {
                    unlink(public_path('/assets/img/' . $data->gambar));
                }

                $gambar  = time() . 'siswa' . '.' . $request->gambar->extension();
                $path       = $request->file('gambar')->move('assets/img', $gambar);

                $data->gambar = $gambar;
            }

            $data->name = $request->nama;
            $data->email = $request->email;
            $data->save();

            if ($data->save()) {

                $siswa = Siswa::where('email', $data->email)->first();
                $siswa->email =  $data->email;
                $siswa->jenis_kelamin =   $request->gender;
                $siswa->kelas_id =   $request->kelas;
                $siswa->jurusan_id =   $request->jurusan;
                $siswa->no_hp =   $request->no_hp;
                $siswa->alamat = $request->alamat;
                $siswa->save();
            }

            DB::commit();
            return redirect()->route('admin.manageSiswa.index')->with('success', 'Data Siswa berhasil perbarui.');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data siswa.');
        }
    }

    public function resetPassword(Request $request, $id)
        {
            $data = User::find($id);

            if (!$data) {
                return redirect()->back()->with('error', 'Data tidak ditemukan.');
            }

            $data->password = Hash::make($request->password);
            $data->save();

            return redirect()->back()->with('success', 'Password siswa berhasil direset.');
        }

    public function destroy($id)
    {
        $data = User::where('id', $id)->first();

        if (!$data) {
            return redirect()->back()->with('error', 'Siswa tidak ditemukan.');
        }

        $siswa = Siswa::where('email', $data->email)->first();
        $siswa->delete();
        $data->delete();

        return redirect()->route('admin.manageSiswa.index')->with('success', 'Siswa berhasil dihapus.');
    }
}
