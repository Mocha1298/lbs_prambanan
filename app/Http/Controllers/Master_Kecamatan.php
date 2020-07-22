<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subdistrict;
use App\Village;
use App\Map;
use App\Photo;
use App\Text;
use App\Type;
use App\User;
use File;
use Illuminate\Support\Facades\Validator;

class Master_Kecamatan extends Controller
{
    public function index()
    {
        $data = Subdistrict::paginate(10);
        $count = Subdistrict::count();
        return view('super.master.master_kecamatan',['data'=>$data,'count'=>$count]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'desa' => 'required|numeric',
            'bujur' => 'required',
            'lintang' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('master_kecamatan#add')
                        ->withErrors($validator)
                        ->withInput();
        }
        $subdistrict = new Subdistrict;
        $subdistrict->nama = $request->nama;
        $subdistrict->desa = $request->desa;
        $subdistrict->bujur = $request->bujur;
        $subdistrict->lintang = $request->lintang;
        $subdistrict->save();
        return redirect('master_kecamatan')->with('simpan','Data sukses disimpan');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'desa' => 'required|numeric',
            'bujur' => 'required',
            'lintang' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('master_kecamatan#popup_e'.$id.'')
                        ->withErrors($validator)
                        ->withInput();
        }

        $subdistrict = Subdistrict::find($id);
        $subdistrict->nama = $request->nama;
        $subdistrict->desa = $request->desa;
        $subdistrict->bujur = $request->bujur;
        $subdistrict->lintang = $request->lintang;
        $subdistrict->save();
        return redirect('master_kecamatan')->with('edit','Data sukses diubah');
    }

    public function destroy($id)
    {
        $subdistrict = Subdistrict::find($id);//AMBIL 1 KCMTN
        $ids = $subdistrict->id;// Ambil ID Kecamatan for del desa
        $village = Village::where('subdistricts_id',$ids)->get();//AMBIL SELURUH DESA PADA ID KCMTN

        //PROSES HAPUS USER
        foreach ($village as $vil ) {//CALL ALL DESA
            $idv = $vil->id;//AMBIL ID PER DESA
            $user = User::where('villages_id',$idv)->first();//CARI USER BASED ID DESA
            $user->delete();//HAPUS USER
        }

        //PROSES
        foreach ($village as $vil ) {//CALL ALL DESA
            $idv = $vil->id;//AMBIL ID DESA

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
            $vil->delete();
        }
        $subdistrict->delete();

        return redirect('master_kecamatan')->with('hapus','Data berhasil dihapus!');
    }
}
