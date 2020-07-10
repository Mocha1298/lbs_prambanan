<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;

class Homepage extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        return view('user.maps');
    }
}
