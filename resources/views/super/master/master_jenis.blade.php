@extends('super.template')

@section('title','JENIS OBJEK')

@section('head')
  {{-- OK BOSSS --}}
  <link rel="stylesheet" href="{{asset('style_admin/table.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/form.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/action.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/alert.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/button.css')}}">
  <link rel="stylesheet" href="{{asset('bs/pagination.css')}}">
  <script src="{{asset('js_admin/nav.js')}}"></script>
@endsection
@section('copy')
oncopy='return false' oncut='return false' onpaste='return false'
@endsection
@section('breadcrump')
    Master Jenis
@endsection
@section('isi')
  <div class="isi">
    <a style="color:white;" class="add" href="#add">Tambah</a>
    <table>
      <caption>Tabel Jenis</caption>
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Kategori</th>
          <th scope="col">Jenis</th>
          <th scope="col">Icon</th>
        </tr>
      </thead>
      <tbody>
        @foreach($data as $nomor => $dt)
          <tr id="{{$dt->id}}" class="table">
            <td data-label="No">{{ $nomor + $data->firstitem()}}</td>
            <td data-label="Kategori">{{ $dt->nama }}</td>
            <td data-label="Jenis">{{ $dt->jenis }}</td>
            <td data-label="Icon"><img width="50px" height="50px" src="{{asset('gambar/jenis/'.$dt->marker.'')}}" alt=""></td>
              {{-- Content Klik Kanan --}}
              <div id="contextMenu" class="cm_{{$dt->id}}" style="display: none">
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
                  <li class="edit">
                    <a href="#popup_e{{$dt->id}}">EDIT</a>
                  </li>
                  @if($dt->jenis != 'Kerusakan')
                  <li class="hapus">
                    <a href="#popup_h{{$dt->id}}">HAPUS</a>
                  </li>
                  @endif
                </ul>
              </div>
          </tr>
        @endforeach
      </tbody>
    </table>
    {{$data->links()}}
  </div>
  @foreach ($data as $dt)
    {{-- POPUP EDIT DATA --}}
    <div id="popup_e{{$dt->id}}" class="overlay">
      <div class="popup">
        <h2>Edit Data Jenis</h2>
        <div class="content">
          <form id="form" action="/master_jenis_ubah/{{$dt->id}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="reset" id="configreset" value="&times;" class="close" onclick="href();">
            <fieldset>
              <input placeholder="Kategori" type="text" autocomplete="off" name="nama" value="{{ $dt->nama ?? old('nama') }}" tabindex="2" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
              @error('nama')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <fieldset>
              <select name="jenis" id="form" required>
                <option @if ($dt->jenis=='' || old('jenis')=='') selected @endif value="">-- PILIH --</option>
                <option @if ($dt->jenis=='Kerusakan' || old('jenis')=='Kerusakan') selected @endif value="Kerusakan">Objek Kerusakan</option>
                <option @if ($dt->jenis=='Peta' || old('jenis')=='Peta') selected @endif value="Peta">Objek Peta</option>
              </select>
              @error('jenis')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <fieldset>
              <input type="file" id="fileimg1" accept="image/*" name="marker">
              <input type="text" name="marker1" hidden value="{{$dt->marker ?? old('marker1')}}">
              <img src="{{asset('gambar/jenis/'.$dt->marker)}}" alt="">
            </fieldset>
            <fieldset>
              <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Simpan</button>
            </fieldset>
            <fieldset>
              <a id="cancel" href="/master_jenis">Cancel</a>
            </fieldset>
        </form>
        </div>
      </div>
    </div>
    {{-- POPUP HAPUS DATA --}}
    <div id="popup_h{{$dt->id}}" class="overlay">
      <div class="popup">
        <h2>Hapus Data Jenis?</h2>
        <div class="content">
          <fieldset class="acc">
            <a class="acc" href="/master_jenis_hapus/{{ $dt->id }}">HAPUS</a>
            <a class="cancel" href="#">BATAL</a>
          </fieldset>
        </div>
      </div>
    </div>
  @endforeach
  <div id="add" class="overlay">
    <div class="popup">
      <h2>Form Tambah Data</h2>
      <div class="content">
        <form id="form" action="/master_jenis_tambah" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <input type="reset" id="configreset" value="&times;" class="close" onclick="href();">
          <fieldset>
            <input placeholder="Kategori" type="text" autocomplete="off" name="nama" value="{{ old('nama') }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
            @error('nama')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
          </fieldset>
          <fieldset>
            <select name="jenis" id="form" required>
              <option @if (old('jenis')=='') selected @endif value="">-- PILIH --</option>
              <option @if (old('jenis')=='Kerusakan') selected @endif value="Kerusakan">Objek Kerusakan</option>
              <option @if (old('jenis')=='Peta') selected @endif value="Peta">Objek Peta</option>
            </select>
            @error('jenis')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
          </fieldset>
          <fieldset>
            <input type="file" id="fileimg" accept="image/*" name="marker" required>
          </fieldset>
          <fieldset>
            <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Simpan</button>
          </fieldset>
          <fieldset>
            <a id="cancel" href="/master_jenis">Cancel</a>
          </fieldset>
      </form>
      </div>
    </div>
  </div>
@endsection
@section('script')
    <script>
      function href() {
        window.location.href = '#';
      }
    </script>
    <script src="{{asset('js_admin/action.js')}}"></script>
@endsection