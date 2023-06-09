<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $data = User::query()
            ->join('siswa', 'siswa.email', 'users.email')
            ->join('kelas', 'kelas.id_kelas', 'siswa.kelas_id')
            ->join('jurusans', 'jurusans.id_jurusan', 'siswa.jurusan_id')
            ->where('users.email', $user->email)
            ->first();

        if ($data) {
            return $this->success($data);
        } else {
            return $this->error('Data tidak ditemukan');
        }
    }

    public function updateProfile(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required',
            'no_hp' => 'required',
            'file' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        if ($validasi->fails()) {
            $val = $validasi->errors()->all();
            return $this->error($val[0]);
        }

        $user = Auth::user();
        $siswa = Siswa::where('email', $user->email)->first();

        if ($user == null || $siswa == null) {
            return $this->error('Data gagal di-update');
        }

        if ($request->hasFile('file')) {
            if (file_exists(public_path('assets/img/' . $user->gambar))) {
                unlink(public_path('assets/img/' . $user->gambar));
            }

            $file = $request->file('file');
            $gambar  = $siswa->nis . '.' . $file->extension();
            $path       = $file->move('assets/img', $gambar);
            
            $user->update([
                'gambar' => $gambar
            ]);
        }

        $user->update([
            'name' => $request->input('name')
        ]);
        $siswa->update([
            'no_hp' => $request->input('no_hp'),
            'alamat' => $request->input('alamat')
        ]);

        if ($siswa->save()) {
            return $this->success('Profile sukses diupdate');
        } else {
            return $this->error('Data No HP dan Alamat gagal diupdate');
        }
    }

    public function updatePassword(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'password' => 'required|min:8',
            'new_password' => 'required|min:8',
            'confirm_password' =>'required|same:new_password',
        ]);
        
        if ($validasi->fails()) {
            $val = $validasi->errors()->all();
            return $this->error($val[0]);
        }

        $user = Auth::user();
        
        if ($user == null) {
            return $this->error('Password gagal di-update');
        }

        if (Hash::check($request->password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            return $this->success("Berhasil diupdate");
        } else {
            return $this->error('Password lama tidak sesuai');
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