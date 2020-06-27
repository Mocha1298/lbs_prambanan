<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuaraWarga extends Controller
{
    public function index()
    {
        return view('user.suara_warga');
    }
}
