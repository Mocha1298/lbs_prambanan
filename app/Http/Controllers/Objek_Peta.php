<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Map;
use App\Type;
use Validator;
use File;
use Image;
use App\Photo;

class Objek_Peta extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipe = Type::where('jenis','Kerusakan')->first();
        $data = Map::join('types','types.id','maps.types_id')
        ->join('photos','photos.id','maps.photos_id')
        ->where('jenis','Peta')
        ->select('maps.*','types.nama as tipe','photos.foto1 as foto1')
        ->paginate(5);
        $tipe = Type::where('jenis','Peta')->get();
        $count = $data->count();
        // return $data;
        return view('super.objek.objek_peta',['data'=>$data,'count'=>$count,'tipe'=>$tipe]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'kategori' => 'required',
            'bujur'=> 'required',
            'lintang'=> 'required',
            'foto1' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
        ]);

        if ($validator->fails()) {
            return redirect('/objek_peta#add')
                        ->withErrors($validator)
                        ->withInput();
        }

        $file = $request->file('foto1');
        $eks = $file->getClientOriginalExtension();//Mengambil ekstensi

        //Menamai gambar
        $imgname ='objek_'.time().'.'.$eks;

        $img = Image::make($file->getRealPath());
        $img->resize(2000, 2000, function ($constraint) {
            $constraint->aspectRatio();
        })->save('gambar/objek/ori/'.$imgname);

        $img->resize(100, 100, function ($constraint) {
            $constraint->aspectRatio();
        })->save('gambar/objek/thumbnail/'.$imgname);

        $ph = new Photo;
        $ph->foto1 = $imgname;
        $ph->save();

        $ph = Photo::latest()->first();

        $pt = new Map;
        $pt->nama = $request->nama;
        $pt->types_id = $request->kategori;
        $pt->bujur = $request->bujur;
        $pt->lintang = $request->lintang;
        $pt->photos_id = $ph->id;
        $pt->save();

        return redirect('/objek_peta')->with('simpan','Data sukses disimpan');
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'kategori' => 'required',
            'bujur'=> 'required',
            'lintang'=> 'required',
            'foto1' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
        ]);

        if ($validator->fails()) {
            return redirect('objek_peta#popup_e'.$id.'')
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = Map::find($id);

        if ($request->hasFile('foto1')) {
            $file = $request->file('foto1');
            $eks = $file->getClientOriginalExtension();//Mengambil ekstensi

            $id = $data->photos_id;
            
            $file1 = Photo::find($id);
            $foto = $file1->foto1;

            // Hapus file lama
            $hapus = "gambar/objek/thumbnail/$foto";
            $hapus1 = "gambar/objek/ori/$foto";
            if(File::exists($hapus)) {
                File::delete($hapus);
                File::delete($hapus1);
            }

            $img = Image::make($file->getRealPath());
            $img->resize(2000, 2000, function ($constraint) {
                $constraint->aspectRatio();
            })->save('gambar/objek/ori/'.$foto);

            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save('gambar/objek/thumbnail/'.$foto);
        }

        $data->nama = $request->nama;
        $data->types_id = $request->kategori;
        $data->bujur = $request->bujur;
        $data->lintang = $request->lintang;

        $data->save();

        return redirect('/objek_peta')->with('edit','Data sukses diubah');
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
    
        return redirect('objek_peta')->with('hapus','Data berhasil dihapus!');
    }
}
