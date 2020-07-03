<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Type;
use Image;
use File;
use Illuminate\Support\Facades\Validator;

class Master_Jenis extends Controller
{

    public function index()
    {
        $data = Type::paginate(5);
        return view ('super.master.master_jenis',['data'=>$data]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'jenis' => 'required',
            'marker' => 'mimes:jpeg,jpg,png,gif|required|max:10000'
        ]);

        if ($validator->fails()) {
            return redirect('master_jenis#add')
                        ->withErrors($validator)
                        ->withInput();
        }

        $file = $request->file('marker');
        $eks = $file->getClientOriginalExtension();
        $imgname ='jenis_'.time().'.'.$eks;
        $img = Image::make($file->getRealPath());
        $img->resize(100, 100, function ($constraint) {
            $constraint->aspectRatio();
        })->save('gambar/jenis/'.$imgname);

        $type = new Type;
        $type->nama = $request->nama;
        $type->jenis = $request->jenis;
        $type->marker = $imgname;
        $type->save();

        return redirect('/master_jenis')->with('simpan','Data sukses disimpan');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'jenis' => 'required',
            'marker' => 'mimes:jpeg,jpg,png,gif|required|max:10000'
        ]);

        if ($validator->fails()) {
            return redirect('master_jenis#popup_e'.$id.'')
                        ->withErrors($validator)
                        ->withInput();
        }
        if($request->hasFile('marker')){
            //Memindah Foto baru
            $file = $request->file('marker');
            $eks = $file->getClientOriginalExtension();
            $imgname ='jenis_'.time().'.'.$eks;
            $img = Image::make($file->getRealPath());
            $img->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
            })->save('gambar/jenis/'.$imgname);
            //HAPUS FOTO LAMA
            $data = Type::find($id);
            $foto = $data->marker;
            $hapus = "gambar/jenis/$foto";
            if(File::exists($hapus)) {
                File::delete($hapus);
            }
        } else {
            $imgname = $request->marker1;
        }
        $data = Type::find($id);
        $data->jenis = $request->jenis;
        $data->nama = $request->nama;
        $data->marker = $imgname;
        $data->save();

        return redirect('/master_jenis')->with('edit','Data sukses diubah');
    }

    public function destroy($id)
    {
        $type = Type::find($id);
        $jenis = $type->jenis;
        if($jenis == 'Kerusakan'){
            return redirect('/master_jenis')->with('hapus','Data tidak dapat dihapus!');
        }
        $foto = $type->marker;
        $data = "gambar/jenis/$foto";
        if(File::exists($data)) {
            File::delete($data);
        }
        $type->delete();
        return redirect('/master_jenis')->with('hapus','Data berhasil dihapus!');
    }
}
