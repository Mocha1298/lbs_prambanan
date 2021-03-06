<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Subdistrict;
use App\Map;
use App\Text;

class AuthController extends Controller
{
    public function index()
    {
        return view('auths.login');
    }
    public function postlogin(Request $request)
    {
        if (Auth::attempt($request->only('nama','password'))) {
            $id = Auth::user()->villages_id;
            if (Auth::user()->roles_id == 1) {
                $data1 = User::count();
                $data2 = Subdistrict::count();
                $data3 = Map::count();
                $data4 = Text::count();
                $data5 = Map::join('types','types.id','maps.types_id')->where('jenis','Peta')->count();
                return view('super.dashboard',['data1'=>$data1,'data2'=>$data2,'data3'=>$data3,'data4'=>$data4,'data5'=>$data5]);
            }
            elseif (Auth::user()->roles_id == 2){
                $data3 = Map::where('villages_id',$id)->count();
                $data4 = Text::where('villages_id',$id)->count();
                return view('super.dashboard',['data3'=>$data3,'data4'=>$data4,'id'=>$id]);
            }
            else{
                return view('user.landing-page');
            }
        }
        return redirect('/login')->with('gagal','Username atau Password tidak cocok!');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
