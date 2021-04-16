<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Village;
use App\Subdistrict;
use File;
use Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class Master_User extends Controller
{
    public function index()
    {
        $data = User::leftjoin('villages','villages.id','users.villages_id')
        ->select('users.*','villages.nama as desa')
        ->orderBy('roles_id','asc')->paginate(5);
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
            'photo' => 'mimes:jpeg,jpg,png,gif|max:10000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $data = User::find($id);
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $eks = $file->getClientOriginalExtension();//Mengambil ekstensi
            $nama_foto = $data->photo;
            if ($nama_foto != 'empty.jpg') {
                // Hapus file lama
                $hapus = "gambar/user/$nama_foto";
                if(File::exists($hapus)) {
                    File::delete($hapus);
                }
                // Menyimpan gambar
                $img = Image::make($file->getRealPath());
                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('gambar/user/'.$nama_foto);
            }
            else{
                //Menamai gambar
                $imgname ='user_'.time().'.'.$eks;
                //Menyimpan gambar
                $img = Image::make($file->getRealPath());
                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('gambar/user/'.$imgname);
                $data->photo = $imgname;
            }
        }
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

    public function enabled($id)
    {
        $data = User::find($id);
        if($data->aktivasi == 0){
            $data->aktivasi = 1;
        }
        else{
            $data->aktivasi = 0;
        }
        $data->save();
        return redirect()->back()->with('edit','Berhasil mengubah aktivasi User..');
    }
}
