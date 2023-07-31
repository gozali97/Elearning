<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller
{
    public function index()
    {
        return view('guru.dashboard');
    }

    public function view()
    {

        $data = User::query()
            ->join('guru', 'guru.email', 'users.email')
            ->where('id', Auth::user()->id)
            ->first();

        return view('guru.profile', compact('data'));
    }

    public function update(Request $request)
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
            $id = Auth::user()->id;

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
            return redirect()->route('guru.profile')->with('success', 'Data Guru berhasil perbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data guru.' . $e->getMessage());
        }
    }

    public function resetPassword(Request $request)
    {

        $id = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8',
        ], [
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters long.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = User::find($id);
        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $data->password = Hash::make($request->password);
        $data->save();

        return redirect()->back()->with('success', 'Password admin berhasil direset.');
    }
}
