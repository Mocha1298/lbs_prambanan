<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Village;
use App\Subdistrict;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class Master_User extends Controller
{
    public function index()
    {
        $data = User::join('villages','villages.id','users.villages_id')
        ->join('subdistricts','subdistricts.id','villages.subdistricts_id')
        ->select('users.*','villages.nama as desa','subdistricts.nama as kecamatan')
        ->orderBy('roles_id','asc')->paginate(10);
        $count = User::count();
        // return $data;
        return view('super.master.master_user',['data'=>$data,'count'=>$count]);
    }
    public function profile($id)
    {
        $data = User::find($id);
        return view('super.profile',['data'=>$data]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('master_user#add')
                        ->withErrors($validator)
                        ->withInput();
        }
        $data = new User;
        $data->nama = $request->nama;
        $data->email = $request->email;
        $password = 'rahasia';
        $data->password = Hash::make($password);
        $data->roles_id = 1;
        $data->aktivasi = 1;
        $data->remember_token = str_random(60);
        $data->save();
        $data->markEmailAsVerified();
        return redirect('/master_user')->with('simpan','Data sukses disimpan');
    }

    public function display(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $data = User::find($id);
        $data->nama = $request->nama;
        $data->email = $request->email;
        $data->save();
        return redirect()->back()->with('edit','Data sukses diubah');
    }

    public function password(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'passwordc' => 'required_with:password|same:password',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $data = User::find($id);
        $password = bcrypt($request->password);
        $data->password = $password;
        $data->save();
        return redirect()->back()->with('edit','Data sukses diubah');
    }

    public function disable($id)
    {
        $data = User::find($id);
        if($data->aktivasi == 1){
            $data->aktivasi = 0;
        }
        else{
            $data->aktivasi = 1;
        }
        $data->save();
        return redirect()->back()->with('edit','Berhasil mengubah aktivasi User..');
    }
}
