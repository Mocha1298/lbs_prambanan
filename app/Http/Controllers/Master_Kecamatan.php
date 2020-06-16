<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subdistrict;
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
            'nama_cmt' => 'required',
            'bujur' => 'required',
            'lintang' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('master_kecamatan#add')
                        ->withErrors($validator)
                        ->withInput();
        }
        $subdistrict = new Subdistrict;
        $subdistrict->nama = $request->nama;
        $subdistrict->desa = $request->desa;
        $subdistrict->nama_cmt = $request->nama_cmt;
        $subdistrict->bujur = $request->bujur;
        $subdistrict->lintang = $request->lintang;
        $subdistrict->save();
        return redirect('master_kecamatan')->with('simpan','Data sukses disimpan');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'desa' => 'required|numeric',
            'nama_cmt' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('master_kecamatan#popup_e'.$id.'')
                        ->withErrors($validator)
                        ->withInput();
        }

        $subdistrict = Subdistrict::find($id);
        $subdistrict->nama = $request->nama;
        $subdistrict->desa = $request->desa;
        $subdistrict->nama_cmt = $request->nama_cmt;
        $subdistrict->save();
        return redirect('master_kecamatan')->with('edit','Data sukses diubah');
    }

    public function destroy($id)
    {
        $subdistrict = Subdistrict::find($id);

        $subdistrict->delete();
    
        return redirect('master_kecamatan')->with('hapus','Data berhasil dihapus!');
    }
}
