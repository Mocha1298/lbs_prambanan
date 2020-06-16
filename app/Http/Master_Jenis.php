<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Type;
use Intervention\Image\Facades\Image;
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
            'jenis' => 'required',
            'kategori' => 'required',
            'marker' => 'mimes:jpeg,jpg,png,gif|required|max:10000'
        ]);

        if ($validator->fails()) {
            return redirect('master_jenis#add')
                        ->withErrors($validator)
                        ->withInput();
        }

        if($request->hasFile('marker')){
            $file = $request->file('marker');
            $eks = $file->getClientOriginalExtension();
            $imgname ='jenis_'.time().'.'.$eks;
            $img = Image::make($file->getRealPath());
            $img->resize(12, 12, function ($constraint) {
                $constraint->aspectRatio();
            })->save('gambar/jenis'.$imgname);
        } else {
            $imgname = 'empty.jpg';
        }
        // return $request;
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
        //
    }
}
