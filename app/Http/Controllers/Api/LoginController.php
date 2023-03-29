<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $token = $user->createToken('MyApp')->accessToken;
        $response = [
            'success' => true,
            'message' => 'Login success',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ];
        return response()->json($response);
    } else {
        $response = [
            'success' => false,
            'message' => 'Login failed',
            'data' => [],
        ];
        return response()->json($response, 401);
    }
}
}
