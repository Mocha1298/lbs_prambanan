<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Text;
use App\Agenda;
use File;
use App\User;
use Illuminate\Support\Facades\Validator;
use App\Map;
use App\Photo;
use Illuminate\Support\Facades\Mail;
use App\Mail\LaporanMasuk;
use Carbon\Carbon;
use Auth;

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
        $data = Text::where('villages_id',$id)->where('status','2')->join('photos','photos.id','texts.photos_id')->join('agendas','agendas.texts_id','texts.id')->select('texts.*','photos.foto1','agendas.survey')->paginate(5);
        $count = $data->count();
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
        $data->status = 2;
        $data->photo = 'empty.jpg';
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
                $hapus = "gambar/survey/thumbnail/$foto";
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
        $kr = new Map;
        $kr->nama = $data->nama;
        $kr->sumber = 0;
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
        $kr->photos_id = $data->photo_id;
        $kr->save();
        return redirect()->back()->with('simpan','Sukses memindah data..');
    }
}
