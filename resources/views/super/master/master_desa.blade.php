@extends('super.template')

@section('title','DESA')

@section('head')
  <link rel="stylesheet" href="{{asset('style_admin/table.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/form.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/action.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/alert.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/button.css')}}">
  <link rel="stylesheet" href="{{asset('bs/pagination.css')}}">
  <script src="{{asset('js_admin/nav.js')}}"></script>
  <script src="{{asset('jquery/jquery.js')}}"></script>
  <script>
    var x=0;
    var id = [];
    var bujur = [];
    var lintang = [];
    var batas = [];
  </script>
  <style>
    input[type=file]#json::before{
      content: 'Pilih File :';
    }
  </style>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
  integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
  crossorigin=""/>
  <script src="{{asset('js_admin/leaflet.js')}}"></script>
@endsection
@section('copy')
oncopy='return false' oncut='return false' onpaste='return false'
@endsection
@section('breadcrump')
    <a href="/master_kecamatan">{{$kc->nama}}</a>
@endsection
@section('isi')
  <div class="isi">
    @if ($admin == 1)
    <a class="add false" href="#">Tambah</a>
    @else
    <a style="color:white;" class="add" href="#add">Tambah</a>
    @endif
    <table>
      <caption>Tabel Desa</caption>
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Nama Desa</th>
          <th scope="col">Jumlah RW</th>
        </tr>
      </thead>
      @if ($count != 0)
        <tbody>
          @foreach($data as $nomor => $ds)
            <tr id="{{$ds->id}}" class="table">
              <td data-label="No">{{ $nomor + $data->firstitem()}}</td>
              <td data-label="Nama Desa">{{ $ds->nama }}</td>
              <td data-label="Jumlah RW">{{ $ds->rw }}</td>
                {{-- Content Klik Kanan --}}
                <div id="contextMenu" class="cm_{{$ds->id}}" style="display: none">
                  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
                    <li class="edit">
                      <a href="#popup_e{{$ds->id}}">EDIT</a>
                    </li>
                    <li class="hapus">
                      <a href="#popup_h{{$ds->id}}">HAPUS</a>
                    </li>
                    <li class="detail">
                      <a href="/objek_kerusakan/{{$ds->id}}">KERUSAKAN</a>
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
  </div>
  @foreach ($data as $ds)
    {{-- POPUP EDIT DATA --}}
    <div id="popup_e{{$ds->id}}" class="overlay">
      <div class="popup">
        <h2>Edit Data</h2>
        <div class="content">
          <form id="form" action="/master_desa_ubah/{{$ds->id}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="reset" id="configreset" value="&times;" class="close" onclick="href();">
            <input type="text" name="id" value="{{$id}}" hidden>
            <fieldset>
              <input placeholder="Nama Desa" type="text" name="nama" value="{{ old('nama') ?? $ds->nama }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" autofocus>
              @error('nama')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <fieldset>
              <input placeholder="Jumlah RW" type="text" name="rw" value="{{ old('rw') ?? $ds->rw }}" tabindex="2" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
              @error('rw')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <fieldset>
              <input id="json" type="file" autocomplete="off" name="batas" tabindex="3" oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
              <p>{{$ds->batas}}</p>
              @error('batas')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <fieldset>
              <input id="bujur{{$ds->id}}" placeholder="Longitude" type="text" name="bujur" value="{{ old('bujur') ?? $ds->bujur }}" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" readonly>
              @error('bujur')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <fieldset>
              <input id="lintang{{$ds->id}}" placeholder="Latitude" type="text" name="lintang" value="{{ old('lintang') ?? $ds->lintang }}" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" readonly>
              @error('lintang')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <fieldset>
            <div onmousemove="getcenter2({{$ds->id}});" class="map" id="mapid{{$ds->id}}" style="width: 100%; height: 40vh;">
                <img class="marker" src="{{asset('gambar/marker/marker.png')}}" alt="">
              </div>
            <fieldset>
            <fieldset>
              <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Simpan</button>
            </fieldset>
            <fieldset>
              <a id="cancel" href="/master_desa/{{$id}}">Cancel</a>
            </fieldset>
        </form>
        </div>
      </div>
    </div>
    {{-- POPUP HAPUS DATA --}}
    <div id="popup_h{{$ds->id}}" class="overlay">
      <div class="popup">
        <h2>Hapus Data?</h2>
        <div class="content">
          <fieldset class="acc">
            <a class="acc" href="/master_desa_hapus/{{ $ds->id }}">HAPUS</a>
            <a class="cancel" href="#">Batal</a>
          </fieldset>
        </div>
      </div>
    </div>
    <script>
      id[x] = {{$ds->id}};
      bujur[x] = {{$ds->bujur}};
      lintang[x] = {{$ds->lintang}};
      batas[x] = "{{$ds->batas}}";
      x++;
    </script>
  @endforeach
  <div id="add" class="overlay">
    <div class="popup">
      <h2>Form Tambah Data</h2>
      <div class="content">
        <form id="form" action="/master_desa_tambah/{{$id}}" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <input type="reset" id="configreset" value="&times;" class="close" onclick="href();">
          <fieldset>
            <input placeholder="Nama Desa" type="text" autocomplete="off" name="nama" value="{{ old('nama') }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" autofocus>
            @error('nama')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
          </fieldset>
          <fieldset>
            <input placeholder="Jumlah RW" type="text" autocomplete="off" name="rw" value="{{ old('rw') }}" tabindex="2" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
            @error('rw')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
          </fieldset>
          <fieldset>
            <input id="json" placeholder="Batas Desa (.json)" type="file" autocomplete="off" name="batas" value="{{ old('batas') }}" tabindex="3" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
            @error('batas')
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
          <fieldset>
            <a id="cancel" href="/master_desa">Cancel</a>
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
    <script>
      var input = "desa";
      var desa = {{$id}};
    </script>
    <script src="{{asset('js_admin/action.js')}}"></script>
    <script src="{{asset('js_admin/ajax.js')}}"></script>
    {{-- <script src="{{asset('js_admin/crud_map.js')}}"></script> --}}
    <script>
      var mymap = [];
      $.getJSON("/center/kecamatan/"+desa, function (data0){
          mymap1 = L.map('mapid',{
              center :  [data0.lintang,data0.bujur],
              zoom: 13,
          });
          var geojsonLayer = new L.GeoJSON.AJAX("/batas/"+data0.batas,{
              fillOpacity : 0,
              color : 'white'
          });    
          geojsonLayer.addTo(mymap1);
          L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
              maxZoom: 20,
              minZoom: 13,
              subdomains:['mt0','mt1','mt2','mt3']
          }).addTo(mymap1);
      });
      // EDIT
      var sid
      var sbujur
      var slintang
      var sbatas;
      console.log(id[2]);
      console.log("Mulai");
      for (var i = 0; i < id.length; i++) {
          sid = id[i];
          sbujur = bujur[i];
          slintang = lintang[i];
          sbatas = batas[i];
          mymap[sid] = L.map("mapid"+sid, {
              center: [slintang,sbujur],
              zoom: 20,
              // scrollWheelZoom: false,
          });
          var geojsonLayer = new L.GeoJSON.AJAX("/batas/"+sbatas,{
              fillOpacity : 0,
              color : 'white'
          });
          geojsonLayer.addTo(mymap[sid]);
          L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
              maxZoom: 20,
              minZoom: 13,
              subdomains:['mt0','mt1','mt2','mt3']
          }).addTo(mymap[sid]);
          
          // Marker Current
          var current = L.icon({
              iconUrl: '/gambar/marker/current.png',
              iconSize:     [17, 17], // size of the icon
              iconAnchor:   [5, 15], // point of the icon which will correspond to marker's location
              popupAnchor:  [-10, -5], // point from which the popup should open relative to the iconAnchor
              tooltipAnchor: [9,-20], //Alhamdulillah nemu bind tool up e aku :D
          });
          L.marker([slintang,sbujur],{icon:current})
          .addTo(mymap[sid])
          .bindPopup("Lokasi terkini");        
      }

      function getcenter1(){
          var center = mymap1.getCenter();
          
          document.getElementById("bujur").value = center.lng;
          document.getElementById("lintang").value = center.lat;
      }

      // EDIT DATA

      function getcenter2(id){
          var center = mymap[id].getCenter();   
          document.getElementById("bujur"+id).value = center.lng;
          document.getElementById("lintang"+id).value = center.lat;
      }
    </script>
@endsection