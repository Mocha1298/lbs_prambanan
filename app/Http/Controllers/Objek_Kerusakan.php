<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Map;
use App\Type;

class Objek_Kerusakan extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datapeta()
    {
        $map = Map::all();
        return $map;
        echo json_encode($map);
    }
    
    public function index()
    {
        return view('super.objek.objek_kerusakan');
    }
    public function index2($id)
    {
        $data = Map::where('villages_id',$id)->join('types','types.id','=','maps.types_id')->paginate(10);
        $count = $data->count();
        return view('super.objek.tabel_kerusakan',['count'=>$count,'data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
