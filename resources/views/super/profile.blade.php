@extends('super.template')

@section('title','Dashboard')

@section('head')
<link rel="stylesheet" href="{{asset('style_admin/alert.css')}}">
<link rel="stylesheet" href="{{asset('style_admin/card.css')}}">
<link rel="stylesheet" href="{{asset('style_admin/form.css')}}">
@endsection

@section('breadcrump')
    Dashboard
@endsection

@section('isi')
<form id="form" action="/display/{{Auth::user()->id}}" method="post">
    @csrf
    <label for="">Display Name dan Email</label>
    <fieldset>
        <input placeholder="Nama" type="text" autocomplete="off" name="nama" value="{{ $data->nama ?? old('nama') }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" autofocus>
        @error('nama')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror 
    </fieldset>
    <fieldset>
        <input placeholder="Email" type="text" autocomplete="off" name="email" value="{{ $data->email ?? old('email') }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" autofocus>
        @error('email')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror 
    </fieldset>
    <fieldset>
        <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Simpan</button>
    </fieldset>
</form>
<form id="form" action="/password/{{Auth::user()->id}}" method="post">
    @csrf
    <label for="">Perbarui Password</label>
    <fieldset>
        <input placeholder="Password" type="password" autocomplete="off" name="password" value="{{ old('password') }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" autofocus>
        @error('password')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror 
    </fieldset>
    <fieldset>
        <input placeholder="Konfirmasi Password" type="password" autocomplete="off" name="passwordc" value="{{ old('passwordc') }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" autofocus>
        @error('passwordc')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror 
    </fieldset>
    <fieldset>
        <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Simpan</button>
    </fieldset>
</form>
@endsection