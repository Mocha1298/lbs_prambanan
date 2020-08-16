<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Text;
use App\Agenda;
use File;
use Illuminate\Support\Facades\Storage;
use App\User;
use Illuminate\Support\Facades\Validator;
use App\Map;
use App\Photo;
use App\Village;
use Illuminate\Support\Facades\Mail;
use App\Mail\LaporanMasuk;
use Carbon\Carbon;
use Auth;
use App\Events\sendName;

class LaporanAgenda extends Controller
{
    public function desa($id)
    {
        // Text::where('created_at', '<', Carbon::now()->subDays(3))->delete();
        $data = Text::where('villages_id',$id)->join('photos','photos.id','texts.photos_id')->select('texts.*','photos.foto1')->paginate(5);
        $count = $data->count();
        return view('super.suwar.laporan',['data'=>$data,'count'=>$count,'id'=>$id]);
    }

    public function agenda($id)
    {
        $data = Text::where('villages_id',$id)->where('status','2')->join('photos','photos.id','texts.photos_id')->join('agendas','agendas.texts_id','texts.id')->select('texts.*','photos.foto1','agendas.survey','agendas.photo')->paginate(5);
        $count = $data->count();
        // return $data;
        return view('super.suwar.agenda',['data'=>$data,'count'=>$count,'id'=>$id]);
    }

    public function acc($id)
    {
        $data  = Text::find($id);
        $id_user = $data->users_id;

        $pengirim = User::find($id_user);

        $idt = $data->id;

        $agenda = new Agenda;
        $agenda->texts_id = $idt;
        $agenda->survey = now();
        $agenda->photo = 'empty.jpg';

        $data->status = 2;

        $text = "Laporan disetujui untuk di survey. Silahkan Cek Profile.";
        $id =  $pengirim->id;
        event(new sendName($text,$id));
        // return "ok";

        $data->save();
        $agenda->save();

        //EMAL USER
        $details = array(
            'baris1' => 'Selamat laporan Anda telah disetujui oleh Pemerintah Desa untuk ditinjau.',
            'baris2' => 'Silahkan tunggu balasan email selanjutnya untuk ke proses selanjutnya. Terima Kasih..',
            'judul' => $data->nama,
            'keterangan' => $data->keterangan,
            'notice' => 'http://localhost:8000/my_suwar/'.$id_user,
        );
        Mail::to($pengirim->email)->send(new LaporanMasuk($details));
        return redirect()->back();
    }

    public function dis($id)
    {
        $data  = Text::find($id);
        $data->status = 3;
        $data->save();
        return redirect()->back();
    }
    public function survey(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'survey'=> 'required',
            'foto' => 'mimes:jpeg,jpg,png,gif|max:10000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $date = Agenda::find($id);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $eks = $file->getClientOriginalExtension();//Mengambil ekstensi
            $foto = $date->photo;
            if ($foto != 'empty.jpg') {
                // Hapus file lama
                $hapus = "gambar/survey/ori/$foto";
                $hapus1 = "gambar/survey/ori/$foto";
                if(File::exists($hapus)) {
                    File::delete($hapus);
                    File::delete($hapus1);
                }

                $img = Image::make($file->getRealPath());
                $img->resize(2000, 2000, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('gambar/survey/ori/'.$foto);

                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('gambar/survey/thumbnail/'.$foto);
            }
            else{
                //Menamai gambar
                $imgname ='survey_'.time().'.'.$eks;
                //Menyimpan gambar
                $img = Image::make($file->getRealPath());
                $img->resize(2000, 2000, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('gambar/survey/ori/'.$imgname);

                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('gambar/survey/thumbnail/'.$imgname);
                $date->photo = $imgname;
                $date->save();
            }
        }
        
        $date->survey = $request->survey;
        $date->save();
        return redirect()->back()->with('edit','Data sukses diubah.');
    }
    public function valid($id)
    {
        $agenda = Agenda::find($id);
        $idt = $agenda->texts_id;
        $data = Text::find($idt);
        $idp = $data->photos_id;

        $kr = new Map;
        $kr->nama = $data->nama;
        $kr->sumber = 0;
        $kr->texts_id = $idt;
        $kr->level = "Ringan";
        $kr->perbaikan = now();
        if ($data->rt) {
            $kr->rt = $data->rt;
        }
        if($data->rw){
            $kr->rw = $data->rw;
        }
        $kr->bujur = $data->bujur;
        $kr->lintang = $data->lintang;
        $kr->types_id = 1;
        $kr->villages_id = $data->villages_id;

        $temp = Photo::find($idp);

        $photo = new Photo;
        $photo->foto1 = $temp->foto1;
        $nama_foto = $temp->foto1;

        $thm_asal = "gambar/laporan/thumbnail/$nama_foto";
        $thm_trgt = "gambar/kerusakan/thumbnail/$nama_foto";
        $ori_asal = "gambar/laporan/ori/$nama_foto";
        $ori_trgt = "gambar/kerusakan/ori/$nama_foto";

        if(File::exists($thm_asal)) {
            // Copy file foto
            // Storage::copy("public/$nama_foto","$nama_foto");
            File::copy("gambar/laporan/thumbnail/".$nama_foto, "gambar/kerusakan/thumbnail/".$nama_foto);
            File::copy("gambar/laporan/ori/".$nama_foto, "gambar/kerusakan/ori/".$nama_foto);
        }
        
        $text = "Laporan Anda akan di masukkan ke data kerusakan. Terima kasih atas kerjasamanya. #PETA-JALAN";
        $id =  $data->users_id;
        event(new sendName($text,$id));
        
        $photo->save();
        $photo = Photo::orderBy('created_at', 'desc')->first();
        $id = $photo->id;
        $kr->photos_id = $id;
        $kr->save();
        return redirect()->back()->with('simpan','Sukses memindah data..');
    }
    // TENGAH PETA
    public function center()
    {
        $id = Auth::user()->villages_id;
        $vil = Village::find($id);
        echo json_encode($vil);
    }
    //DATA LAPORAN
    public function datapeta()
    {
        $id = Auth::user()->villages_id;
        $data = Text::where('villages_id',$id)
        ->join('photos','photos.id','texts.photos_id')
        ->select('texts.*','photos.*')
        ->get();
        echo json_encode($data);
    }
    public function peta_agenda()
    {
        $id = Auth::user()->villages_id;
        $data = Text::where('villages_id',$id)
        ->join('photos','photos.id','texts.photos_id')
        ->join('agendas','agendas.texts_id','texts.id')
        ->select('texts.*','photos.*','agendas.*')
        ->get();
        echo json_encode($data);
    }
}
