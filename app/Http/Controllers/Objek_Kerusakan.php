<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Map;
use App\Type;
use App\Photo;
use Image;
use File;
use Illuminate\Support\Facades\Validator;

class Objek_Kerusakan extends Controller
{
    public function datapeta()
    {
        $map = Map::all();
        return $map;
        echo json_encode($map);
    }
    
    public function index()
    {
        return view('super.objek.objek_kerusakan');
    }

    public function index2($id)//Berdasarkan Desa
    {
        $data = Map::where('villages_id',$id)->join('types','types.id','=','maps.types_id')->join('photos','photos.id','maps.photos_id')->select('maps.*','types.nama as status','photos.id as idp','photos.foto1','photos.foto2','photos.foto3')->paginate(10);
        $count = $data->count();
        $tipe = Type::where('jenis','Kerusakan')->get();
        // return $data;
        return view('super.objek.objek_kerusakan',['count'=>$count,'data'=>$data,'tipe'=>$tipe,'id'=>$id]);
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
            return redirect('objek_kerusakan/'.$id.'#add')
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
    
            $img->resize(100, 100, function ($constraint) {
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
        $data->rt = $request->rt;
        $data->rw = $request->rw;
        $data->bujur = $request->bujur;
        $data->lintang = $request->lintang;
        $data->villages_id = $id;
        
        $tipe = Type::where('nama','Rencana')->first();

        $data->types_id = $tipe->id;
        $data->photos_id = $ph->id;
        $data->save();

        return redirect('/objek_kerusakan/'.$id.'')->with('simpan','Data sukses disimpan');
    }

    public function foto(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'foto1' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
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

        $img->resize(100, 100, function ($constraint) {
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
            'rt' => 'required',
            'rw' => 'required',
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

                $img->resize(100, 100, function ($constraint) {
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

                $img->resize(100, 100, function ($constraint) {
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

                $img->resize(100, 100, function ($constraint) {
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

                $img->resize(100, 100, function ($constraint) {
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

                $img->resize(100, 100, function ($constraint) {
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

                $img->resize(100, 100, function ($constraint) {
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

        return redirect('/objek_kerusakan/'.$id.'')->with('edit','Data sukses diubah');
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

        return redirect('/objek_kerusakan/'.$id.'')->with('edit','Data sukses diubah');
    }

    public function destroy($id)
    {
        $data = Map::find($id);
        $pt = $data->photos_id;
        $foto = Photo::find($pt);

        $foto1 = $foto->foto1;
        $file_t = "gambar/objek/thumbnail/$foto1";
        $file_o = "gambar/objek/ori/$foto1";

        if(File::exists($file_t)) {
            File::delete($file_t);
            File::delete($file_o);
        }

        $foto->delete();

        $data->delete();
    
        return redirect('objek_kerusakan/'.$id.'')->with('hapus','Data berhasil dihapus!');
    }
}
