<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Village;
use App\Subdistrict;
use App\Photo;
use App\Text;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\LaporanMasuk;
use Illuminate\Support\Facades\Validator;
use Image;
use File;
use Auth;

class SuaraWarga extends Controller
{
    public function index()
    {
        $kc = Subdistrict::where('nama','Prambanan')->first();
        $data = Village::where('subdistricts_id',$kc->id)->get();
        return view('user.suara_warga',['data'=>$data]);
    }
    public function index1($id)
    {
        $data = Text::where('users_id',$id)->join('villages','villages.id','texts.villages_id')->join('photos','photos.id','texts.photos_id')->select('texts.*','villages.nama as nama_desa','photos.foto1')->paginate(5);
        $count = $data->count();
        // return $data;
        return view('user.my_suwar',['data'=>$data,'count'=>$count,'id'=>$id]);
    }



    public function create()
    {
        return view('captchacreate');
    }

    public function display(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/my_suwar#edit')
                        ->withErrors($validator)
                        ->withInput();
        }
        $data = User::find($id);
        $data->nama = $request->nama;
        $data->email = $request->email;
        $data->save();
        return redirect('my_suwar');
    }

    public function password(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'passwordc' => 'required_with:password|same:password',
        ]);

        if ($validator->fails()) {
            return redirect('/my_suwar#edit')
                        ->withErrors($validator)
                        ->withInput();
        }
        $data = User::find($id);
        $password = bcrypt($request->password);
        $data->password = $password;
        $data->save();
        return redirect('my_suwar');
    }

    public function captchaValidate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'keterangan' => 'required',
            'rt' => 'numeric',
            'rw' => 'numeric',
            'desa' => 'required',
            'bujur' => 'required',
            'lintang' => 'required',
            'foto1' => 'required|mimes:jpeg,jpg,png,gif|max:10000',
            'captcha' => 'required|captcha'
        ]);

        if ($validator->fails()) {
            return redirect('/suwar')
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $file = $request->file('foto1');
        $eks = $file->getClientOriginalExtension();//Mengambil ekstensi

        //Menamai gambar
        $imgname ='laporan_'.time().'.'.$eks;

        $img = Image::make($file->getRealPath());
        $img->resize(2000, 2000, function ($constraint) {
            $constraint->aspectRatio();
        })->save('gambar/laporan/ori/'.$imgname);

        $img->resize(100, 100, function ($constraint) {
            $constraint->aspectRatio();
        })->save('gambar/laporan/thumbnail/'.$imgname);

        $ph = new Photo;
        $ph->foto1 = $imgname;
        $ph->save();

        $ph = Photo::latest()->first();

        $data = new Text;
        $data->nama = $request->nama;
        $data->status = 1;
        $data->keterangan = $request->keterangan;
        $data->rt = $request->rt;
        $data->rw = $request->rw;
        $data->bujur = $request->bujur;
        $data->lintang = $request->lintang;
        $data->villages_id = $request->desa;
        $data->photos_id = $ph->id;
        $data->users_id = Auth::user()->id;

        $id_desa = $request->desa;
        $desa = Village::find($id_desa);

        // EMAIL ADMIN
        $details = array(
            'baris1' => 'Kepada Pemerintah Desa '.$desa->nama, 
            'baris2' => 'Laporan masuk dari Saudara/i '.Auth::user()->nama,
            'judul' => $request->nama,
            'keterangan' => $request->keterangan,
            'notice' => 'http://localhost:8000/suwar_admin/'.$request->desa,
        );

        $admin = User::where('villages_id',$request->desa)->first();
        Mail::to($admin)->send(new LaporanMasuk($details));

        $details = array(
            'baris1' => 'Terima Kasih atas laporan yang Anda berikan untuk kami.',
            'baris2' => 'Mohon menunggu 2x24 jam untuk kami meninjau laporan Anda.',
            'judul' => $request->nama,
            'keterangan' => $request->keterangan,
            'notice' => 'http://localhost:8000/my_suwar/'.Auth::user()->id,
        );

        $user = Auth::user()->email;
        Mail::to($user)->send(new LaporanMasuk($details));

        $data->save();

        return redirect('/suwar')->with('simpan','Data sukses disimpan');
    }
    public function refreshCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }
}
