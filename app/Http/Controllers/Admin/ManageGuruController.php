<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ManageGuruController extends Controller
{
    public function index()
    {

        $guru = User::query()
            ->join('guru', 'guru.email', 'users.email')
            ->where('role_id', 2)
            ->get();
        // dd($guru);
        return view('admin.guru.index', compact('guru'));
    }

    public function view($id)
    {

        $guru = User::query()
            ->join('guru', 'guru.email', 'users.email')
            ->where('role_id', 2)
            ->where('id', $id)
            ->get();
        return view('admin.guru.index', compact('guru'));
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

            $gambar  = time() . 'guru' . '.' . $request->gambar->extension();
            $path       = $request->file('gambar')->move('assets/img', $gambar);

            DB::beginTransaction();

            $user = new User;
            $user->name = $request->nama;
            $user->gambar = $gambar;
            $user->role_id = 2;
            $user->email = $request->email;
            $user->password = Hash::make('12345678');


            if ($user->save()) {

                $jumlahData = Guru::count();

                if ($jumlahData > 0) {
                    $nomorUrutan = $jumlahData + 1;
                    $nip = 'MA00' . $nomorUrutan;
                } else {
                    $nip = 'MA001';
                }

                Guru::create([
                    'nip' => $nip,
                    'email' =>  $user->email,
                    'jenis_kelamin' =>   $request->gender,
                    'no_hp' =>   $request->no_hp,
                    'alamat' => $request->alamat,
                ]);
            }

            DB::commit();
            return redirect()->route('manageGuru.index')->with('success', 'Data Guru berhasil ditambahkan.');
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            if (strpos($errorMessage, 'users_email_unique') !== false) {
                $errorMessage = 'Alamat email telah digunakan. Silakan gunakan alamat email lain.';
            } else {
                $errorMessage = 'Terjadi kesalahan saat menyimpan data guru.';
            }
            return redirect()->back()->with('error', $errorMessage);
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

                if (file_exists(public_path('assets/img' . $data->gambar))) {
                    unlink(public_path('assets/img' . $data->gambar));
                }

                $gambar  = time() . 'guru' . '.' . $request->gambar->extension();
                $path       = $request->file('gambar')->move('assets/img', $gambar);

                $data->gambar = $gambar;
            }

            $data->name = $request->nama;
            $data->email = $request->email;
            $data->save();

            if ($data->save()) {

                $guru = Guru::where('email', $data->email)->first();
                $guru->email =  $data->email;
                $guru->jenis_kelamin =   $request->gender;
                $guru->no_hp =   $request->no_hp;
                $guru->alamat = $request->alamat;
                $guru->save();
            }

            DB::commit();
            return redirect()->route('manageGuru.index')->with('success', 'Data Guru berhasil perbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data guru.' . $e->getMessage());
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

        return redirect()->back()->with('success', 'Password guru berhasil direset.');
    }

    public function destroy($id)
    {
        $data = User::where('id', $id)->first();

        if (!$data) {
            return redirect()->back()->with('error', 'Guru tidak ditemukan.');
        }

        $guru = Guru::where('email', $data->email)->first();
        $guru->delete();
        $data->delete();

        return redirect()->route('manageGuru.index')->with('success', 'Guru berhasil dihapus.');
    }
}
