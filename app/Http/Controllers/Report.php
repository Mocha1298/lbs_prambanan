<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Text;
use App\Village;
use PDF;
use Carbon;

class Report extends Controller
{
    public function index($id)
    {
        $data = Text::where('texts.villages_id',$id)
        ->leftjoin('agendas','agendas.texts_id','texts.id')
        ->leftjoin('maps','maps.nama','texts.nama')
        ->leftjoin('users','texts.users_id','users.id')
        ->leftjoin('villages','texts.villages_id','villages.id')
        ->select('texts.*','agendas.created_at as setuju','maps.created_at as valid','users.nama as sender','villages.nama as desa')
        ->paginate(5);
        return view('super.report.report',['data'=>$data]);
    }
    public function cetak()
    {
        return view('super.report.cetak');
    }

    public function filter(Request $request)
    {
        $filter = $request->filter;
        $awal = $request->dari;
        $akhir = $request->sampai;
        $hasil = Text::leftjoin('agendas','agendas.texts_id','texts.id')
        ->leftjoin('maps','maps.nama','texts.nama')
        ->leftjoin('users','texts.users_id','users.id')
        ->leftjoin('villages','texts.villages_id','villages.id')
        ->select('texts.*','agendas.created_at as setuju','maps.created_at as valid','users.nama as sender','villages.nama as desa')
        ->whereDate($filter,'>=',$awal)
        ->whereDate($filter,'<=',$akhir)
        ->get();
        // $pdf = PDF::loadView('cetak',['hasil'=>$hasil]);
        // return $pdf->stream('laporan.pdf');
        return view('cetak',['hasil'=>$hasil]);
    }
}
