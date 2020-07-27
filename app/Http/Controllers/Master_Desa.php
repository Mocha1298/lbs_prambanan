<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subdistrict;
use App\Village;
use App\Photo;
use App\Map;
use App\Text;
use App\Type;
use App\Agenda;
use File;
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

    public function index2($id)//ID KECMTN
    {
        $kc = Subdistrict::find($id);
        // return $kc;
        $limit = $kc->desa;
        $ds = Village::where('subdistricts_id',$id);
        $count = $ds->count();
        if ($limit == $count) {
            $admin = 1;
        }
        else{
            $admin = 0;
        }
        $data = $ds->paginate(10);
        return view('super.master.master_desa',['data'=>$data,'id'=>$id,'kc'=>$kc,'count'=>$count,'admin'=>$admin]);
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
        $user->nama = 'Admin_'.$request->nama;
        $nama = str_replace(' ','_', $request->nama);
        $email = 'Admin.'.$request->nama.'@gmail.com';
        $email = str_replace(' ','.', $email);
        $user->email = $email;
        $password = 'rahasia';
        $user->password = Hash::make($password);
        $user->roles_id = 2;
        $user->aktivasi = 1;
        $user->villages_id = $last->id;
        $user->photo = 'empty.jpg';
        $user->save();
        $user->markEmailAsVerified();
        return redirect()->back()->with('simpan','Data sukses disimpan');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'rw' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $village = Village::find($id);
        $village->nama = $request->nama;
        $village->rw = $request->rw;
        $village->subdistricts_id = $request->id;
        $village->save();
        return redirect()->back()->with('edit','Data sukses diubah');
    }

    public function destroy($id)
    {
        $village = Village::find($id);
        $idv = $village->id;
        $map = Map::where('villages_id',$idv)->get();//CALL DATA WITH QUERY
        foreach ($map as $mp) {//CALL ALL DATA
            $idm = $mp->photos_id;//AMBIL ID KRSKN
            $idm_st = $mp->types_id;//AMBIL ID TIPE
            $photo1 = Photo::find($idm);//CALL PHOTO
            $status = Type::find($idm_st);//CALL TYPE
            $status = $status->nama;
            $foto;//VAR SAVE DATA POTO
            $x;//PANJANG DATA
            if($status == 'Rencana'){
                $foto[0] = $photo1->foto1;
                $x = 1;
            }
            elseif($status == 'Sedang'){
                $foto[0] = $photo1->foto1;
                $foto[1] = $photo1->foto2;
                $x = 2;
            }
            else{
                $foto[0] = $photo1->foto1;
                $foto[1] = $photo1->foto2;
                $foto[2] = $photo1->foto3;
                $x = 3;
            }
            for ($i=0; $i < $x; $i++) { 
                $fotos = $foto[$i];
                if($fotos != 'empty.jpg'){
                    $file_o = "gambar/kerusakan/ori/$fotos";
                    $file_t = "gambar/kerusakan/thumbnail/$fotos";
                    if(File::exists($file_t)) {
                        File::delete($file_t);
                        File::delete($file_o);
                    }
                }
            }
            $mp->delete();
            $photo1->delete();
        }
        //MULAI CARI DATA LAPORAN

        $text = Text::where('villages_id',$idv)->get();//CALL DATA WITH QUERY
        foreach ($text as $tx) {//CALL ALL DATA
            $idt = $tx->id;
            $idp = $tx->photos_id;
            $photo2 = Photo::find($idp);
            $foto= $photo2->foto1;
            if($foto != 'empty.jpg'){
                $file_o = "gambar/laporan/ori/$foto";
                $file_t = "gambar/laporan/thumbnail/$foto";
                if(File::exists($file_t)) {
                    File::delete($file_t);
                    File::delete($file_o);
                }
            }
            $tx->delete();
            $photo2->delete();
        }
        $id = $village->subdistrict_id;
        $village->delete();
    
        return redirect()->back()->with('hapus','Data berhasil dihapus!');
    }
}
