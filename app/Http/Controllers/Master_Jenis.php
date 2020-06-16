<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Type;
use Image;
use File;
use Illuminate\Support\Facades\Validator;

class Master_Jenis extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Type::paginate(10);
        return view ('super.master.master_jenis',['data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori' => 'required',
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
        $type->jenis = $request->jenis;
        $type->kategori = $request->kategori;
        $type->marker = $imgname;
        $type->save();

        return redirect('/master_jenis')->with('simpan','Data sukses disimpan');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = Type::find($id);
        $foto = $type->marker;
        $data = "gambar/jenis/$foto";
        if(File::exists($data)) {
            File::delete($data);
        }
        $type->delete();
        return redirect('/master_jenis')->with('hapus','Data berhasil dihapus!');
    }
}
