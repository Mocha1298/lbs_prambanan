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
        $data = Map::where('villages_id',$id)->join('types','types.id','=','maps.types_id')->join('photos','photos.id','=','maps.photos_id')->select('maps.*','types.nama as status','photos.foto1')->paginate(10);
        $count = $data->count();
        $tipe = Type::where('jenis','Kerusakan')->get();
        // return $data;
        return view('super.objek.tabel_kerusakan',['count'=>$count,'data'=>$data,'tipe'=>$tipe,'id'=>$id]);
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
            'foto1' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
        ]);

        if ($validator->fails()) {
            return redirect('objek_kerusakan/'.$id.'#add')
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

        $ph = new Photo;
        $ph->foto1 = $imgname;
        $ph->save();

        $ph = Photo::latest()->first();

        $kr = new Map;
        $kr->nama = $request->nama;
        $kr->level = $request->level;
        $kr->perbaikan = $request->perbaikan;
        $kr->rt = $request->rt;
        $kr->rw = $request->rw;
        $kr->bujur = $request->bujur;
        $kr->lintang = $request->lintang;
        $kr->villages_id = $id;
        
        $tipe = Type::where('jenis','Kerusakan')->first();

        $kr->types_id = $tipe->id;
        $kr->photos_id = $ph->id;
        $kr->save();

        return redirect('/objek_kerusakan/'.$id.'')->with('simpan','Data sukses disimpan');
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
        ]);

        $kr = Map::find($id)->join('types','types.id','=','maps.types_id')->join('photos','photos.id','=','maps.photos_id')->select('maps.*','types.nama as status','photos.*')->first();

        if ($validator->fails()) {
            return redirect('objek_kerusakan/'.$kr->villages_id.'#popup_e'.$id.'')
                        ->withErrors($validator)
                        ->withInput();
        }

        if ($request->hasFile('foto1')) {
            $file = $request->file('foto1');
            $eks = $file->getClientOriginalExtension();//Mengambil ekstensi

            // Inisialisasi Status
            if ($kr->status == 'Rencana') {
                $nama_foto = $kr->foto1;
            }
            elseif ($kr->status == 'Sedang'){
                $nama_foto = $kr->foto2;
            }
            else{
                $nama_foto = $kr->foto3;
            }

            // Hapus file lama
            $foto = $nama_foto;
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

        $kr->nama = $request->nama;
        $kr->level = $request->level;
        $kr->perbaikan = $request->perbaikan;
        $kr->rt = $request->rt;
        $kr->rw = $request->rw;
        $kr->bujur = $request->bujur;
        $kr->lintang = $request->lintang;

        $kr->save();

        return redirect('/objek_kerusakan/'.$id.'')->with('edit','Data sukses diubah');
    }

    public function destroy($id)
    {
        //
    }
}
