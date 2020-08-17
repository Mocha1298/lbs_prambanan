@extends('super.template')

@section('title','OBJEK PETA')

@section('head')
  <link rel="stylesheet" href="{{asset('style_admin/table.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/form.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/action.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/alert.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/button.css')}}">
  <link rel="stylesheet" href="{{asset('bs/pagination.css')}}">
  <style>
    #peta{
      width: 100%;
      height: 500px;
    }
  </style>
  <script src="{{asset('js_admin/nav.js')}}"></script>
  <script src="{{asset('jquery/jquery.js')}}"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
  integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
  crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
@endsection
@section('copy')
oncopy='return false' oncut='return false' onpaste='return false'
@endsection
@section('breadcrump')
    @if (Auth::user()->roles_id != 2)
        Objek Peta
    @endif
@endsection
@section('isi')
  <div class="isi">
    <div style="display: flex;justify-content:space-between;" class="half">
      <a style="color:white;" class="add" href="#add">Tambah</a>
      <a style="right: 0; width: 50px;" href="#map"><i style="width: 28px; height: 28px; color: mediumseagreen;" class="fa fa-globe fa-2x"></i></a>
    </div>
    <table>
      <caption>Tabel Objek Peta</caption>
      <thead>
        <tr>
          <th scope="col">Nama</th>
          <th scope="col">Kategori</th>
          <th scope="col">Foto</th>
        </tr>
      </thead>
      @if ($count != 0)
        <tbody>
          @foreach($data as $pt)
            <tr id="{{$pt->id}}" class="table">
              <td data-label="Nama">{{ $pt->nama }}</td>
              <td data-label="Kategori">{{ $pt->tipe }}</td>
              <td data-label="Foto"><a href="/gambar/objek/ori/{{ $pt->foto1 }}"><img src="/gambar/objek/thumbnail/{{ $pt->foto1 }}" alt="" width="80px" height="auto"></a></td>
                {{-- Content Klik Kanan --}}
                <div id="contextMenu" class="cm_{{$pt->id}}" style="display: none">
                  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
                    <li class="edit">
                      <a href="#popup_e{{$pt->id}}">EDIT</a>
                    </li>
                    <li class="hapus">
                      <a href="#popup_h{{$pt->id}}" >HAPUS</a>
                    </li>
                  </ul>
                </div>
            </tr>
          @endforeach
        </tbody>
      @else
        <tbody>
          <tr>Data masih kosong! tambah sekarang...</tr>
        </tbody>
      @endif
    </table>
    {{$data->links()}}
  </div>
  @foreach ($data as $pt)
    {{-- POPUP EDIT DATA --}}
    <div id="popup_e{{$pt->id}}" class="overlay">
      <div class="popup">
        <h2>Edit Desa</h2>
        <div class="content">
          <form id="form" action="/objek_peta_ubah/{{$pt->id}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="reset" id="configreset" value="&times;" class="close" onclick="href();">
            <fieldset>
              <input placeholder="Nama Kerusakan" type="text" autocomplete="off" name="nama" value="{{ old('nama') ?? $pt->nama }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" autofocus>
              @error('nama')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror 
            </fieldset>
            <fieldset>
              <select name="kategori" id="">
                <option disabled 
                @if ($pt->types_id == '')
                    selected
                @endif
                >--Pilih Kategori--</option>
                @foreach ($tipe as $item)
                  <option value="{{$item->id}}"
                  @if (old('kategori') == '')
                    @if ($pt->types_id == $item->id)
                        selected
                    @endif
                  @elseif(old('kategori') == $item->id)  
                      selected
                  @endif
                  >{{$item->nama}}</option>
                @endforeach
              </select>
              @error('kategori')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror 
            </fieldset>
            <fieldset>
              <input style="margin-top: 10px" type="file" id="fileimg1" accept="image/*" name="foto1">
              <img style="margin-left: 20px" src="/gambar/objek/thumbnail/{{$pt->foto1}}" alt="">
              @error('foto1')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror 
            </fieldset>
            <fieldset>
              <input id="bujur{{$pt->id}}" placeholder="Longitude" type="text" name="bujur" value="{{ old('bujur') ?? $pt->bujur }}" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" readonly>
              @error('bujur')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <fieldset>
              <input id="lintang{{$pt->id}}" placeholder="Latitude" type="text" name="lintang" value="{{ old('lintang') ?? $pt->lintang }}" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" readonly>
              @error('lintang')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <fieldset>
            <div onmousemove="getcenter2({{$pt->id}});" class="map" id="mapid{{$pt->id}}" style="width: 100%; height: 40vh;">
                <img class="marker" src="{{asset('gambar/marker/marker.png')}}" alt="">
              </div>
            <fieldset>
            <fieldset>
              <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Simpan</button>
            </fieldset>
        </form>
        </div>
      </div>
    </div>
    {{-- POPUP HAPUS DATA --}}
    <div id="popup_h{{$pt->id}}" class="overlay">
      <div class="popup">
        <h2>Hapus Objek Peta?</h2>
        <div class="content">
          <fieldset class="acc">
            <a class="acc" href="/objek_peta_hapus/{{ $pt->id }}">HAPUS</a>
            <a class="cancel" href="#">Batal</a>
          </fieldset>
        </div>
      </div>
    </div>
  @endforeach
  <div id="add" class="overlay">
    <div class="popup">
      <h2>Tambah Data</h2>
      <div class="content">
        <form id="form" action="/objek_peta_tambah" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <input type="reset" id="configreset" value="&times;" class="close" onclick="href();">
          <fieldset>
            <input placeholder="Nama Objek" type="text" autocomplete="off" name="nama" value="{{ old('nama') }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" autofocus>
            @error('nama')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror 
          </fieldset>
          <fieldset>
            <select name="kategori" id="">
              <option disabled 
                @if (old('kategori') == '')
                    selected
                @endif value="">--Pilih Kategori--</option>
              @foreach ($tipe as $item)
                <option
                @if (old('kategori') == '$item->id')
                    selected
                @endif
                value="{{$item->id}}">{{$item->nama}}</option>
              @endforeach
            </select>
            @error('kategori')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror 
          </fieldset>
          <fieldset>
            <input style="margin-top: 10px" type="file" id="fileimg1" accept="image/*" name="foto1">
            @error('foto1')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror 
          </fieldset>
          <fieldset>
            <input id="bujur" placeholder="Longitude" type="text" name="bujur" value="{{ old('bujur') }}" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" readonly>
            @error('bujur')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
          </fieldset>
          <fieldset>
            <input id="lintang" placeholder="Latitude" type="text" name="lintang" value="{{ old('lintang') }}" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" readonly>
            @error('lintang')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
          </fieldset>
          <fieldset>
            <div onmousemove="getcenter1();" id="mapid" style="width: 100%; height: 35vh;">
              <img class="marker" src="{{asset('gambar/marker/marker.png')}}" alt="">
            </div>
          </fieldset>
          <fieldset>
            <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Simpan</button>
          </fieldset>
      </form>
      </div>
    </div>
  </div>
  <div id="map" class="overlay">
    <div class="popup">
      <h2>Peta Agenda</h2>
      <a href="#" class="close">&times;</a>
      <div class="content">
        <div id="peta"></div>
      </div>
    </div>
  </div>
@endsection
@section('script')
    <script>
      function href() {
        window.location.href = '#';
      }
      var input = "objek";
      var desa = 6;
    </script>
    <script src="{{asset('js_admin/action.js')}}"></script>
    <script src="{{asset('js_admin/bundle.js')}}"></script>
    <script src="{{asset('js_admin/polygon.js')}}"></script>
    <script src="{{asset('js_admin/ajax.js')}}"></script>
    <script src="{{asset('js_admin/crud_map.js')}}"></script>
    <script>
      var peta1;
      peta1 = L.map('peta',{
          center :  [-7.7520153,110.4892787],
          watch : true,
          zoom: 14,
          closePopupOnClick: false
      });

      L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
        minZoom: 10,
        maxZoom: 20,
        subdomains:['mt0','mt1','mt2','mt3']
      }).addTo(peta1);
      $.getJSON("/dataobjek", function (data){
        for (var i = 0; i < data.length; i++) {
          console.log(data[i].id);
          var icon = L.icon({
              iconUrl: '/gambar/jenis/'+data[i].marker,
              iconSize:     [30, 30],
          });
          var name = data[i].nama;
          var status = data[i].status;
          L.marker([data[i].lintang, data[i].bujur],{icon: icon})
          .bindPopup(
              (info =
                  "<div class='cont'>"
                      +"<div class='box'>"
                          +"<div class='header'>"
                              +"<h2><strong>"+name+"</strong></h2>"
                          +"</div>"
                          +"<img src='/gambar/objek/thumbnail/"+data[i].foto1+"' alt=''>"
                      +"</div>"
                  +"</div>"
                  )
          ).addTo(peta1);
        }
      })
    </script>
@endsection