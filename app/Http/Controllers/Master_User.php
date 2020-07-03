<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class Master_User extends Controller
{
    public function index()
    {
        $data = User::paginate(10);
        $count = User::count();
        return view('super.master.master_user',['data'=>$data,'count'=>$count]);
    }

    public function create()
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
