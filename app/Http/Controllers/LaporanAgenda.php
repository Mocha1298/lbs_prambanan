<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Text;
use App\Agenda;
use Carbon\Carbon;

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
        $idt = $data->id;
        $agenda = new Agenda;
        $agenda->texts_id = $idt;
        $agenda->survey = now();
        $data->status = 2;
        $data->save();
        $agenda->save();
        return redirect()->back();
    }

    public function dis($id)
    {
        $data  = Text::find($id);
        $data->status = 3;
        $data->save();
        return redirect()->back();
    }
}
