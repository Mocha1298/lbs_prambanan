<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{asset('style_user/suwar.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/alert.css')}}">
  <script src="{{asset('jquery/jquery.js')}}"></script>
  <script src="https://use.fontawesome.com/46ea1af652.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=MuseoModerno:wght@600&display=swap" rel="stylesheet">
  <script src="{{asset('jquery/jquery-3.5.1.slim.min.js')}}"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
  integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
  crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
  <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <title>Suara Warga</title>
</head>
<body>
  <a href="/" class="home"><i class="fa fa-home fa-3x"></i></a>
  <a href="/my_suwar/{{Auth::user()->id}}" class="my-report"><i class="fa fa-camera fa-3x"></i></a>
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
    <select name="desa">
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
  <script src="{{asset('js_admin/action.js')}}"></script>
  <script src="{{asset('js_admin/bundle.js')}}"></script>
  <script src="{{asset('js_admin/polygon.js')}}"></script>
  <script src="{{asset('js_admin/crud_map.js')}}"></script>
</body>
</html>