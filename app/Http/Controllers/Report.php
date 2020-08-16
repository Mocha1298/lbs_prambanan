<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Text;
use App\Village;

class Report extends Controller
{
    public function index()
    {
        $data = Text::leftjoin('agendas','agendas.texts_id','texts.id')
        ->leftjoin('maps','maps.nama','texts.nama')
        ->leftjoin('users','texts.users_id','users.id')
        ->leftjoin('villages','texts.villages_id','villages.id')
        ->select('texts.*','agendas.created_at as setuju','maps.created_at as valid','users.nama as sender','villages.nama as desa')
        ->get();
        $desa = Village::all();
        return view('super.report.report',['data'=>$data,'desa'=>$desa]);
    }
    public function cetak()
    {
        return view('super.report.cetak');
    }
}
