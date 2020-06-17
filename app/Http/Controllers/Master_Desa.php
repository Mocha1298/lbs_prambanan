<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subdistrict;
use App\Village;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class Master_Desa extends Controller
{
    public function index()
    {
        $data = Village::paginate(10);
        $count = Village::count();
        return view ('super.master.master_desa',['data'=>$data,'count'=>$count]);
    }

    public function index2($id)
    {
        $kc = Subdistrict::find($id);
        $limit = $kc->desa;
        $count = Village::where('subdistricts_id',$id)->count();
        if ($limit == $count) {
            $admin = 1;
        }
        else{
            $admin = 0;
        }
        $data = Village::where('subdistricts_id',$id)->paginate(10);
        return view('super.master.master_desa',['data'=>$data,'id'=>$id,'count'=>$count,'admin'=>$admin]);
    }
    public function index3($id)
    {
        $ds = Village::find($id);
        $idk = $ds->subdistricts_id;
        $kc = Subdistrict::find($idk);
        $limit = $kc->desa;
        $count = Village::where('subdistricts_id',$idk)->count();
        if ($limit == $count) {
            $admin = 1;
        }
        else{
            $admin = 0;
        }
        $data = Village::where('subdistricts_id',$idk)->paginate(10);
        $id = $idk;
        return view('super.master.master_desa',['data'=>$data,'id'=>$id,'count'=>$count,'admin'=>$admin]);
    }

    public function create2(Request $request, $id)//Input berdasarkan kecamatan
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'rw' => 'required|numeric',
            'bujur' => 'required',
            'lintang' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('master_desa#add')
                        ->withErrors($validator)
                        ->withInput();
        }

        $village = new Village;
        $village->nama = $request->nama;
        $village->rw = $request->rw;
        $village->bujur = $request->bujur;
        $village->lintang = $request->lintang;
        $village->subdistricts_id = $id;
        $village->save();

        $last = Village::latest('id')->first();

        $user = new User;
        $user->nama = 'Admin'.$request->nama;
        $user->email = 'admin'.$request->nama.'@gmail.com';
        $password = 'rahasia';
        $user->password = Hash::make($password);
        $user->roles_id = 2;
        $user->aktivasi = 1;
        $user->villages_id = $last->id;
        $user->save();
        return redirect('master_desa/'.$id.'')->with('simpan','Data sukses disimpan');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'rw' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect('master_desa/'.$request->id.'#popup_e'.$id.'')
                        ->withErrors($validator)
                        ->withInput();
        }

        $village = Village::find($id);
        $village->nama = $request->nama;
        $village->rw = $request->rw;
        $village->subdistricts_id = $request->id;
        $village->save();
        return redirect('master_desa/'.$request->id.'')->with('edit','Data sukses diubah');
    }

    public function destroy($id_k,$id)
    {
        $Village = Village::find($id);

        $User = User::where('villages_id',$id)->first();

        $User->delete();

        $Village->delete();
    
        return redirect('/master_desa/'.$id_k.'')->with('hapus','Data berhasil dihapus!');
    }
}
