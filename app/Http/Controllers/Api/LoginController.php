<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
            $user = Auth::user();

            if ($user->role->name === 'admin') {
                return $this->success($user);
            }

            if ($user->role->name === 'guru') {
                return $this->success($user);
            }

            if ($user->role->name === 'user') {
                return $this->success($user);
            }

            // return response()->json([
            //     'data' => [],
            //     'status' => 'success',
            //     'message' => 'Login successful',
            // ]);
        }

        return $this->error("Email atau Password anda salah");
    }

    public function logout(Request $request)
    {
        Auth::logout();

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
