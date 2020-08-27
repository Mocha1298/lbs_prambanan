@extends('user.lay')

@section('head')
<link rel="stylesheet" href="{{asset('style_user/suwar.css')}}">
<link rel="stylesheet" href="{{asset('style_admin/alert.css')}}">
{{-- LEAFLET --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
crossorigin=""/>
<script src="{{asset('js_admin/leaflet.js')}}"></script>
@endsection

@section('title','SUARA WARGA')
@section('isi')
@section('profile')
<a title="ke halaman profil" class="navoption" href="/my_suwar/{{Auth::user()->id}}">Profile</a>
@endsection
  <div class="judul">
    <h3 id="logo">Suara Warga</h3>
  </div>
  <form method="post" action="/post_suwar" enctype="multipart/form-data">
    @csrf
    @if (session('simpan'))
    <div class="success"><i class="fa fa-check-circle-o fa-2x" aria-hidden="true"></i>{{session('simpan')}}</div>
    @endif

    <label for="nama">Judul Laporan</label>
    <input type="text" id="nama" name="nama" placeholder="Tulis Judul laporan Anda.." value="{{old('nama')}}" autocomplete="off" required maxlength="50"/>
    @error('nama')
    <div class="invalid-feedback">
        {{$message}}
    </div>
    @enderror
    <br>

    <label for="keterangan">Keterangan</label>
    <input type="text" id="keterangan" name="keterangan" placeholder="Tulis Keterangan laporan Anda.." value="{{old('keterangan')}}" autocomplete="off" required maxlength="200"/>
    @error('keterangan')
    <div class="invalid-feedback">
        {{$message}}
    </div>
    @enderror
    <br>

    <label for="desa">DESA</label>
    <select id="desa" name="desa">
      <option class="dis" @if (old('desa') == '') selected @endif disabled>Pilih Desa laporan Anda..</option>
      @foreach ($data as $dt)
        <option @if (old('desa') == $dt->id) selected @endif value="{{$dt->id}}">{{$dt->nama}}</option>
      @endforeach
    </select>
    @error('desa')
    <div class="invalid-feedback">
        {{$message}}
    </div>
    @enderror
    <br>
    
    <label for="rw">RW (optional)</label>
    <input type="text" id="rw" name="rw" placeholder="Tulis  laporan Anda.." value="{{old('rw')}}" autocomplete="off" />
    @error('rw')
    <div class="invalid-feedback">
        {{$message}}
    </div>
    @enderror
    <br>
    
    <label for="rt">RT (optional)</label>
    <input type="text" id="rt" name="rt" placeholder="Tulis judul laporan Anda.." value="{{old('rt')}}" autocomplete="off" />
    @error('rt')
    <div class="invalid-feedback">
        {{$message}}
    </div>
    @enderror
    <br>

    <label for="foto1">Foto Laporan</label>
    <input style="margin-top: 10px" type="file" accept="image/*" name="foto1">
    @error('foto1')
    <div class="invalid-feedback">
        {{$message}}
    </div>
    @enderror
    <br>

    <input id="bujur" placeholder="Longitude" type="text" name="bujur" value="{{ old('bujur') }}" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" readonly>
    @error('bujur')
    <div class="invalid-feedback">
        {{$message}}
    </div>
    @enderror
    <br>

    <input id="lintang" placeholder="Latitude" type="text" name="lintang" value="{{ old('lintang') }}" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" readonly>
    @error('lintang')
    <div class="invalid-feedback">
        {{$message}}
    </div>
    @enderror
    <br>

    <div onmousemove="getcenter1();" id="mapid" style="width: 100%; height: 35vh;margin-bottom: 20px">
      <img class="marker" src="{{asset('gambar/marker/marker.png')}}" alt="">
    </div>

    <label style="width: 100%" for="captcha">Captcha</label>
    <div class="captcha">
      <span>{!! captcha_img() !!}</span>
    </div>
    <div class="btn-refresh">
      <button id="refresh" type="button" class="refresh"><i class="fa fa-refresh"></i></button>
    </div>

    <input id="captcha" type="text" placeholder="Masukan Captcha" name="captcha" autocomplete="off" required>
    @error('captcha')
    <div class="invalid-feedback">
        {{$message}}
    </div>
    @enderror

    <input type="submit" name="submit" value="Kirim" />

  </form>
  <script src="{{asset('js_admin/ajax.js')}}"></script>
  <script type="text/javascript">
    $('#refresh').click(function(){
        $.ajax({
          type:'GET',
          url:'refreshcaptcha',
          success:function(data){
              $(".captcha span").html(data.captcha);
          }
        });
      });
  </script>
  <script>
    var geojsonLayer;
    var kec = {{$kc->id}}
    var mymap;
    function map() {
      $.getJSON("/center/kecamatan/"+kec, function (data){
          mymap = L.map('mapid',{
              center :  [data.lintang,data.bujur],
              watch : true,
              zoom: 13,
              closePopupOnClick: false
          });
          geojsonLayer = new L.GeoJSON.AJAX("/batas/"+data.batas,{
          fillOpacity : 0,
          color : 'white'
          }).addTo(mymap);
          L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
              maxZoom: 20,
              minZoom: 12,
              subdomains:['mt0','mt1','mt2','mt3']
          }).addTo(mymap);
      });
    }
    map()

    function getcenter1(){
        var center = mymap.getCenter();
        
        document.getElementById("bujur").value = center.lng;
        document.getElementById("lintang").value = center.lat;
    }
  </script>
@endsection