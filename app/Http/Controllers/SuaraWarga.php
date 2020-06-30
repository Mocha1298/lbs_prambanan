<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Village;
use App\Subdistrict;

class SuaraWarga extends Controller
{
    public function index()
    {
        $kc = Subdistrict::where('nama','Prambanan')->first();
        $data = Village::where('subdistricts_id',$kc->id)->get();
        return view('user.suara_warga',['data'=>$data]);
    }
    public function create()
    {
        return view('captchacreate');
    }
    public function captchaValidate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'captcha' => 'required|captcha'
        ]);
    }
    public function refreshCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }
}
