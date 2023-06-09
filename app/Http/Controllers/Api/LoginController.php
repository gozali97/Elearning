<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();

            if ($user->role->name === 'admin') {
                return $this->success($user);
            }

            if ($user->role->name === 'guru') {
                return $this->success($user);
            }

            if ($user->role->name === 'user') {
                $user['siswa'] = Siswa::select('nis')->where('email', $user->email)->first();
                $user['siswa']['token'] = $user->createToken("api_token")->plainTextToken;
                return $this->success($user);
            }
        }

        return $this->error("Email atau Password anda salah");
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return $this->success('200');
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