<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function index(Request $request)
    {

        $email = $request->input('email');

        $data = User::query()
            ->join('siswa', 'siswa.email', 'users.email')
            ->join('kelas', 'kelas.id_kelas', 'siswa.kelas_id')
            ->join('jurusans', 'jurusans.id_jurusan', 'siswa.jurusan_id')
            ->where('users.email', $email)
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
            'email' => 'required',
            'name' => 'required',
            'no_hp' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        if ($validasi->fails()) {
            $val = $validasi->errors()->all();
            return $this->error($val[0]);
        }

        $user = User::where('email', $request->input('email'))->first();
        $siswa = Siswa::where('email', $request->input('email'))->first();

        if ($user == null || $siswa == null) {
            return $this->error('Data gagal di-update');
        }

        if ($request->hasFile('gambar')) {
            if (file_exists(public_path('assets/img/' . $user->gambar))) {
                unlink(public_path('assets/img/' . $user->gambar));
            }

            $file = $request->file('gambar');
            $gambar  = $siswa->nis . '.' . $file->extension();
            $path       = $file->move('assets/img', $gambar);
            $user->gambar = $gambar;
        }

        $user->name = $request->input('name');
        $siswa->update([
            'no_hp' => $request->input('no_hp'),
            'alamat' => $request->input('alamat')
        ]);
        // $siswa->no_hp = $request->input('no_hp');
        // $siswa->alamat = $request->input('alamat');

        if ($user->save()) {
            if ($siswa->save()) {
                return $this->success('Profile sukses diupdate');
            } else {
                return $this->error('Data No HP dan Alamat gagal diupdate');
            }
        } else {
            return $this->error('Profile gagal diupdate');
        }
    }

    public function updatePassword(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'id' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'new_password' => 'required|min:8',
            'confirm_password' =>'required|same:new_password',
        ]);
        
        if ($validasi->fails()) {
            $val = $validasi->errors()->all();
            return $this->error($val[0]);
        }
        
        $data = User::Select('password')->where([
            ['id', $request->input('id')],
            ['email', $request->input('email')],
        ])->first();
        
        if ($data == null) {
            return $this->error('Data gagal di-update');
        }

        if (Hash::check($request->password, $data->password)) {
            $data->password = Hash::make($request->new_password);
            if ($data->save()) {
                return $this->success($data);
            } else {
                return $this->error('Data gagal diupdate');
            }
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
