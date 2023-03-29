<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function redirectTo()
    {
        $user = auth()->user();

        if ($user->role->name === 'admin') {
            return route('admin');
        }

        if ($user->role->name === 'guru') {
            return route('guru');
        }

        if ($user->role->name === 'user') {
            return route('user');
        }

        return route('home');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
