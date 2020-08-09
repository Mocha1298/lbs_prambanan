<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Map;
use App\Type;
use App\Photo;
use App\Subdistrict;
use App\Village;
use Image;
use File;
use Auth;
use Illuminate\Support\Facades\Validator;

// OK

class Objek_Kerusakan extends Controller
{
    public function datapeta()
    {
        $id = Auth::user()->villages_id;
        $map = Map::where('villages_id',$id)
        ->join('photos','photos.id','maps.photos_id')
        ->get();
        echo json_encode($map);
    }
    public function center()
    {
        $id = Auth::user()->villages_id;
        $data = Village::find($id);
        echo json_encode($data);
    }
    
    public function index()
    {
        return view('super.objek.objek_kerusakan');
    }

    public function index2($id)//Berdasarkan Desa
    {
        $data = Map::where('villages_id',$id)->join('types','types.id','=','maps.types_id')->join('photos','photos.id','maps.photos_id')->select('maps.*','types.nama as status','photos.id as idp','photos.foto1','photos.foto2','photos.foto3')->paginate(5);
        $count = $data->count();
        $tipe = Type::where('jenis','Kerusakan')->get();
        $vil = Village::find($id);
        $ids = $vil->subdistricts_id;
        $kc = Subdistrict::find($ids);
        // return $data;
        return view('super.objek.objek_kerusakan',['count'=>$count,'data'=>$data,'tipe'=>$tipe,'id'=>$id,'ids'=>$ids,'kc'=>$kc,'vil'=>$vil]);
    }

    public function create(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'level' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'perbaikan' => 'required',
            'bujur'=> 'required',
            'lintang'=> 'required',
            'foto1' => 'mimes:jpeg,jpg,png,gif|max:10000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        if ($request->hasFile('foto1')) {
            $file = $request->file('foto1');
            $eks = $file->getClientOriginalExtension();//Mengambil ekstensi
    
            //Menamai gambar
            $imgname ='kerusakan_'.time().'.'.$eks;
    
            $img = Image::make($file->getRealPath());
            $img->resize(2000, 2000, function ($constraint) {
                $constraint->aspectRatio();
            })->save('gambar/kerusakan/ori/'.$imgname);
    
            $img->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->save('gambar/kerusakan/thumbnail/'.$imgname);
        }
        else{
            //Menamai gambar
            $imgname ='empty.jpg';
        }

        $ph = new Photo;
        $ph->foto1 = $imgname;
        $ph->save();

        $ph = Photo::latest()->first();

        $data = new Map;
        $data->nama = $request->nama;
        $data->level = $request->level;
        $data->perbaikan = $request->perbaikan;
        $data->sumber = 1;
        $data->rt = $request->rt;
        $data->rw = $request->rw;
        $data->bujur = $request->bujur;
        $data->lintang = $request->lintang;
        $data->villages_id = $id;
        
        $tipe = Type::where('nama','Rencana')->first();

        $data->types_id = $tipe->id;
        $data->photos_id = $ph->id;
        $data->save();

        return redirect()->back()->with('simpan','Data sukses disimpan');
    }

    public function foto(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'foto1' => 'required|mimes:jpeg,jpg,png,gif|required|max:10000',
        ]);
        
        $data = Map::find($id);
        $tipe = Type::find($data->types_id);

        if ($validator->fails()) {
            return redirect('objek_kerusakan/'.$data->villages_id.'#popup_e'.$id.'')
                        ->withErrors($validator)
                        ->withInput();
        }

        $file = $request->file('foto1');
        $eks = $file->getClientOriginalExtension();//Mengambil ekstensi

        //Menamai gambar
        $imgname ='kerusakan_'.time().'.'.$eks;

        $img = Image::make($file->getRealPath());
        $img->resize(2000, 2000, function ($constraint) {
            $constraint->aspectRatio();
        })->save('gambar/kerusakan/ori/'.$imgname);

        $img->resize(300, 300, function ($constraint) {
            $constraint->aspectRatio();
        })->save('gambar/kerusakan/thumbnail/'.$imgname);

        $idf = $data->photos_id;
        $ph = Photo::find($idf);
        if ($tipe->nama == 'Rencana') {
            $ph->foto1 = $imgname;
        }
        elseif ($tipe->nama == 'Sedang'){
            $ph->foto2 = $imgname;
        }
        else {
            $ph->foto3 = $imgname;
        }
        $ph->save();
        return redirect('/objek_kerusakan/'.$data->villages_id.'')->with('edit','Data sukses diubah');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'level' => 'required',
            'rt' => 'numeric',
            'rw' => 'numeric',
            'perbaikan' => 'required',
            'bujur'=> 'required',
            'lintang'=> 'required',
            'foto1' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'foto2' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'foto3' => 'mimes:jpeg,jpg,png,gif|max:10000',
        ]);

        if ($validator->fails()) {
            return redirect('objek_kerusakan/'.$data->villages_id.'#popup_e'.$id.'')
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = Map::find($id);
        $idp = $data->photos_id;
        $photo = Photo::find($idp);
        $id = $data->villages_id;

        if ($request->hasFile('foto1')) {
            $file = $request->file('foto1');
            $eks = $file->getClientOriginalExtension();//Mengambil ekstensi
            $nama_foto = $photo->foto1;
            if ($nama_foto != 'empty.jpg') {
                // Hapus file lama
                $foto = $data->foto1;//Init nama foto db
                $hapus = "gambar/kerusakan/thumbnail/$foto";
                $hapus1 = "gambar/kerusakan/ori/$foto";
                if(File::exists($hapus)) {
                    File::delete($hapus);
                    File::delete($hapus1);
                }

                $img = Image::make($file->getRealPath());
                $img->resize(2000, 2000, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('gambar/kerusakan/ori/'.$foto);

                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('gambar/kerusakan/thumbnail/'.$foto);
            }
            else{
                //Menamai gambar
                $imgname ='kerusakan_'.time().'.'.$eks;
                //Menyimpan gambar
                $img = Image::make($file->getRealPath());
                $img->resize(2000, 2000, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('gambar/kerusakan/ori/'.$imgname);

                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('gambar/kerusakan/thumbnail/'.$imgname);
                $photo->foto1 = $imgname;
                $photo->save();
            }
        }
        if ($request->hasFile('foto2')) {
            $file = $request->file('foto2');
            $eks = $file->getClientOriginalExtension();//Mengambil ekstensi
            $nama_foto = $photo->foto2;

            if ($nama_foto != 'empty.jpg') {
                // Hapus file lama
                $foto = $data->foto2;//Init nama foto db
                $hapus = "gambar/kerusakan/thumbnail/$foto";
                $hapus1 = "gambar/kerusakan/ori/$foto";
                if(File::exists($hapus)) {
                    File::delete($hapus);
                    File::delete($hapus1);
                }

                $img = Image::make($file->getRealPath());
                $img->resize(2000, 2000, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('gambar/kerusakan/ori/'.$foto);

                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('gambar/kerusakan/thumbnail/'.$foto);
            }
            else{
                //Menamai gambar
                $imgname ='kerusakan_'.time().'.'.$eks;
                //Menyimpan gambar
                $img = Image::make($file->getRealPath());
                $img->resize(2000, 2000, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('gambar/kerusakan/ori/'.$imgname);

                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('gambar/kerusakan/thumbnail/'.$imgname);
                $photo->foto2 = $imgname;
                $photo->save();
            }
        }
        if ($request->hasFile('foto3')) {
            $file = $request->file('foto3');
            $eks = $file->getClientOriginalExtension();//Mengambil ekstensi
            $nama_foto = $photo->foto3;

            if ($nama_foto != 'empty.jpg') {
                // Hapus file lama
                $foto = $data->foto3;//Init nama foto db
                $hapus = "gambar/kerusakan/thumbnail/$foto";
                $hapus1 = "gambar/kerusakan/ori/$foto";
                if(File::exists($hapus)) {
                    File::delete($hapus);
                    File::delete($hapus1);
                }

                $img = Image::make($file->getRealPath());
                $img->resize(2000, 2000, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('gambar/kerusakan/ori/'.$foto);

                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('gambar/kerusakan/thumbnail/'.$foto);
            }
            else{
                //Menamai gambar
                $imgname ='kerusakan_'.time().'.'.$eks;
                //Menyimpan gambar
                $img = Image::make($file->getRealPath());
                $img->resize(2000, 2000, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('gambar/kerusakan/ori/'.$imgname);

                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('gambar/kerusakan/thumbnail/'.$imgname);
                $photo->foto3 = $imgname;
                $photo->save();
            }
        }

        $data->nama = $request->nama;
        $data->level = $request->level;
        $data->perbaikan = $request->perbaikan;
        $data->rt = $request->rt;
        $data->rw = $request->rw;
        $data->bujur = $request->bujur;
        $data->lintang = $request->lintang;

        $data->save();

        return redirect()->back()->with('edit','Data sukses diubah');
    }

    public function update1(Request $request, $id)
    {
        $data = Map::find($id);
        $idp = $data->photos_id;
        $photo = Photo::find($idp);
        if ($request->kategori == 1) {
            if($photo->foto1 == ''){
                $photo->foto1 = 'empty.jpg';
                $photo->save();
            }
        }
        elseif($request->kategori == 2){
            if($photo->foto2 == ''){
                $photo->foto2 = 'empty.jpg';
                $photo->save();
            }
        }
        else{
            if($photo->foto3 == ''){
                $photo->foto3 = 'empty.jpg';
                $photo->save();
            }
        }
        $id = $data->villages_id;
        $data->types_id = $request->kategori;
        $data->save();

        return redirect()->back()->with('edit','Data sukses diubah');
    }

    public function destroy($id)
    {
        $map = Map::find($id);//CALL DATA WITH QUERY
        $idm = $map->photos_id;//AMBIL ID KRSKN
        $idm_st = $map->types_id;//AMBIL ID TIPE
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
        $id = $map->villages_id;
        $map->delete();
        $photo1->delete();
    
        return redirect('objek_kerusakan/'.$id.'')->with('hapus','Data berhasil dihapus!');
    }
}
