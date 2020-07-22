<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Map;
use App\Village;
use App\Subdistrict;
use App\Photo;
use App\Type;

class Homepage extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function center()
     {
         $center = Subdistrict::where('nama','Prambanan')->first();
         echo json_encode($center);
     }

     public function datapeta()
     {
        $data = Subdistrict::where('nama','Prambanan')->first();
        $id = $data->id;
        $data = Village::where('subdistricts_id',$id)
        ->join('maps','maps.villages_id','villages.id')
        ->join('photos','photos.id','maps.photos_id')
        ->join('types','types.id','maps.types_id')
        ->where('types.jenis','Kerusakan')
        ->select('maps.id','maps.nama as kerusakan','maps.level','maps.perbaikan','maps.rt','maps.rw','maps.lintang','maps.bujur','maps.types_id','maps.photos_id'
            ,'villages.nama as desa'
            ,'photos.foto1','photos.foto2','photos.foto3'
            ,'types.nama as status','types.marker')->get();
        echo json_encode($data);
     }

     public function objek()
     {
        $objek = Map::join('types','types.id','maps.types_id')
        ->join('photos','photos.id','maps.photos_id')
        ->select('maps.*','types.marker','types.nama as jenis','photos.foto1');
        $objek = $objek->where('jenis','Peta')->get();
        echo json_encode($objek);
     }
    public function landing()
    {
        return view('home');
    }

    public function bergabung(Request $request)
    {
        $email = $request->email;
        return view('user.join_form',['email'=>$email]);
    }

    public function join_form(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required',
            'password' => 'required',
            'passwordc' => 'required_with:password|same:password',
        ]);

        if ($validator->fails()) {
            return redirect('join_form')
                        ->withErrors($validator)
                        ->withInput();
        }
        $data = new User;
        $data->nama = $request->nama;
        $data->email = $request->email;
        $password = $request->password;
        $data->password = Hash::make($password);
        $data->roles_id = 3;
        $data->aktivasi = 1;
        $data->remember_token = str_random(60);
        $data->save();
        $data->sendEmailVerificationNotification();
        return redirect('/');
    }

    public function maps()
    {
        $objek = Map::join('types','types.id','maps.types_id')
        ->join('photos','photos.id','maps.photos_id')
        ->select('maps.*','types.marker','types.nama as jenis','photos.foto1');
        $objek = $objek->where('jenis','Peta')->get();

        $desa = Village::join('subdistricts','subdistricts.id','villages.subdistricts_id')->select('villages.*','subdistricts.nama as kc')->get();
        $desa = $desa->where('kc','Prambanan');
        // return $desa;

        $data = Subdistrict::where('nama','Prambanan')->first();
        $id = $data->id;
        $data = Village::where('subdistricts_id',$id)
        ->join('maps','maps.villages_id','villages.id')
        ->join('photos','photos.id','maps.photos_id')
        ->join('types','types.id','maps.types_id')
        ->where('types.jenis','Kerusakan')
        ->select('maps.id','maps.nama as kerusakan','maps.level','maps.perbaikan','maps.rt','maps.rw','maps.lintang','maps.bujur','maps.types_id','maps.photos_id'
            ,'villages.nama as desa'
            ,'photos.foto1','photos.foto2','photos.foto3'
            ,'types.nama as status','types.marker')->get();

        return view('user.maps',['data'=>$data,'objek'=>$objek,'desa'=>$desa]);
    }
}
