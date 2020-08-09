@extends('super.template')

@section('title','PROFILE')

@section('head')
<link rel="stylesheet" href="{{asset('style_admin/alert.css')}}">
<link rel="stylesheet" href="{{asset('style_admin/form.css')}}">
@endsection

@section('breadcrump')
    PROFILE
@endsection

@section('isi')
<form id="form" action="/display/{{Auth::user()->id}}" method="post" enctype="multipart/form-data">
    @csrf
    <fieldset>
        <label for="">Ubah Nama</label>
        <input placeholder="Nama" type="text" autocomplete="off" name="nama" value="{{ Auth::user()->nama ?? old('nama') }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" autofocus>
        @error('nama')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror 
    </fieldset>
    <fieldset>
        <label for="">Ubah Email</label>
        <input placeholder="Email" type="text" autocomplete="off" name="email" value="{{ Auth::user()->email ?? old('email') }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" autofocus>
        @error('email')
        <div class="invalid-feedback">
            {{$message}}
        </div>
        @enderror 
    </fieldset>
    <fieldset>
        <label for="">Ubah Foto Profile</label>
        <input style="margin-top: 10px" type="file" id="fileimg1" accept="image/*" name="photo">
        <img style="margin-left: 20px" width="100px" height="auto" src="/gambar/user/{{Auth::user()->photo}}">
        @error('photo')
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