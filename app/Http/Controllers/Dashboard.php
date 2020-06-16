<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Map;
use App\Subdistrict;
use App\Text;

class Dashboard extends Controller
{
    public function index()
    {
        $data1 = User::count();
        $data2 = Subdistrict::count();
        $data3 = Map::count();
        $data4 = Text::count();
        return view('super.dashboard',['data1'=>$data1,'data2'=>$data2,'data3'=>$data3,'data4'=>$data4]);
    }
}
