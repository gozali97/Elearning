<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ManageGuruController extends Controller
{
    public function index(){

        $guru = User::where('role_id', 2)->get();
        return view('admin.guru.index', compact('guru'));
    }
}
