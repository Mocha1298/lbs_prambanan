@extends('super.template')

@section('title','KECAMATAN')

@section('head')
  <link rel="stylesheet" href="{{asset('style_admin/table.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/form.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/action.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/alert.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/button.css')}}">
  <style>
    input[type=file]#json::before{
      content: 'Pilih File :';
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
    Kecamatan
@endsection
@section('isi')
  <div class="isi">
    <table>
      <caption>Tabel Kecamatan</caption>
      <thead>
        <tr>
          <th scope="col">Nama Kecamatan</th>
          <th scope="col">Jumlah Desa</th>
        </tr>
      </thead>
      @if ($count != 0)
        <tbody>
          @foreach($data as $kc)
          <tr id="{{$kc->id}}" class="table">
            <td data-label="Nama Kecamatan">{{ $kc->nama }}</td>
            <td data-label="Jumlah Desa">{{ $kc->desa }}</td>
              {{-- Content Klik Kanan --}}
              <div id="contextMenu" class="cm_{{$kc->id}}" style="display: none">
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
                  <li class="edit">
                    <a href="#popup_e{{$kc->id}}">EDIT</a>
                  </li>
                  <li class="hapus">
                    <a href="#popup_h{{$kc->id}}">HAPUS</a>
                  </li>
                  <li class="detail">
                    <a href="/master_desa/{{$kc->id}}">DETAIL</a>
                  </li>
                </ul>
              </div>
          </tr>
          @endforeach
        </tbody>
      @else
        <tbody>
          <tr class="table">Belum ada data! Tambah sekarang...</tr>
        </tbody>
      @endif
    </table>
    <div class="pagination">
        <a style="color:white;" class="add" href="#add">Tambah</a>
        <?php
          // config
          $link_limit = 7;
          ?>

          @if ($data->lastPage() > 1)
              <ul>
                  <li class="{{ ($data->currentPage() == 1) ? ' disabled' : '' }}">
                      <a href="{{ $data->url(1) }}">First</a>
                  </li>
                  @for ($i = 1; $i <= $data->lastPage(); $i++)
                      <?php
                      $half_total_links = floor($link_limit / 2);
                      $from = $data->currentPage() - $half_total_links;
                      $to = $data->currentPage() + $half_total_links;
                      if ($data->currentPage() < $half_total_links) {
                        $to += $half_total_links - $data->currentPage();
                      }
                      if ($data->lastPage() - $data->currentPage() < $half_total_links) {
                          $from -= $half_total_links - ($data->lastPage() - $data->currentPage()) - 1;
                      }
                      ?>
                      @if ($from < $i && $i < $to)
                          <li class="{{ ($data->currentPage() == $i) ? ' active' : '' }}">
                              <a href="{{ $data->url($i) }}">{{ $i }}</a>
                          </li>
                      @endif
                  @endfor
                  <li class="{{ ($data->currentPage() == $data->lastPage()) ? ' disabled' : '' }}">
                      <a href="{{ $data->url($data->lastPage()) }}">Last</a>
                  </li>
              </ul>
          @endif
    </div>
  </div>
  @foreach ($data as $kc)
    {{-- POPUP EDIT DATA --}}
    <div id="popup_e{{$kc->id}}" class="overlay">
      <div class="popup">
        <h2>Edit Data Kecamatan</h2>
        <div class="content">
          <form id="form" action="/master_kecamatan_ubah/{{$kc->id}}" method="post" enctype="multipart/form-data">
            <input type="reset" id="configreset" value="&times;" class="close" onclick="href();">
            {{ csrf_field() }}
            <fieldset>
              <input placeholder="Nama Kecamatan" type="text" name="nama" value="{{ old('nama') ?? $kc->nama }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" autofocus>
              @error('nama')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <fieldset>
              <input placeholder="Jumlah Desa" type="text" name="desa" value="{{ old('desa') ?? $kc->desa }}" tabindex="2" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
              @error('desa')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <fieldset>
              <input id="json" type="file" autocomplete="off" name="batas" tabindex="3" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
              <p>{{$kc->batas}}</p>
              @error('batas')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <fieldset>
              <input id="bujur{{$kc->id}}" placeholder="Longitude" type="text" name="bujur" value="{{ old('bujur') ?? $kc->bujur }}" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" readonly>
              @error('bujur')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset> 
            <fieldset>
              <input id="lintang{{$kc->id}}" placeholder="Latitude" type="text" name="lintang" value="{{ old('lintang') ?? $kc->lintang }}" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" readonly>
              @error('lintang')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <fieldset>
              <div onmousemove="getcenter2({{$kc->id}});" class="map" id="mapid{{$kc->id}}" style="width: 100%; height: 40vh;">
                <img class="marker" src="{{asset('gambar/marker/marker.png')}}" alt="">
              </div>
            <fieldset>
            <fieldset>
              <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Submit</button>
            </fieldset>
            <fieldset>
              <a id="cancel" href="/master_kecamatan">Cancel</a>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
    {{-- POPUP HAPUS DATA --}}
    <div id="popup_h{{$kc->id}}" class="overlay">
      <div class="popup">
        <h2>Hapus Data Kecataman</h2>
        <div class="content">
          <p style="color: firebrick;margin-bottom: 20px">Intruksi ini akan menghapus seluruh data yang berhubungan dengan master tersebut, apakah Anda yakin untuk melanjutkan intruksi ini?</p>
          <fieldset class="acc">
            <a class="acc" href="/master_kecamatan_hapus/{{ $kc->id }}">YA, Saya Yakin!</a>
            <a class="cancel" href="#">Batal</a>
          </fieldset>
        </div>
      </div>
    </div>
  @endforeach
  {{-- POPUP TAMBAH DATA --}}
  <div id="add" class="overlay">
    <div class="popup">
      <h2>Form Tambah Data</h2>
      <div class="content">
        <form id="form" action="/master_kecamatan_tambah" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <input type="reset" id="configreset" value="&times;" class="close" onclick="href();">
          <fieldset>
            <input placeholder="Nama Kecamatan" autocomplete="off" type="text" name="nama" value="{{ old('nama') }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" autofocus>
            @error('nama')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
          </fieldset>
          <fieldset>
            <input placeholder="Jumlah Desa" autocomplete="off" type="text" name="desa" value="{{ old('desa') }}" tabindex="2" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
            @error('desa')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
          </fieldset>
          <fieldset>
            <input id="json" type="file" autocomplete="off" name="batas" tabindex="3" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
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
            <div onmousemove="getcenter1();" id="mapid" style="width: 100%; height: 40vh;">
              <img class="marker" src="{{asset('gambar/marker/marker.png')}}" alt="">
            </div>
          </fieldset>
          <fieldset>
            <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Simpan</button>
          </fieldset>
          <fieldset>
            <a id="cancel" href="/master_kecamatan">Cancel</a>
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
      // DETEKSI USER
      var input = "kecamatan";
    </script>
    <script src="{{asset('js_admin/action.js')}}"></script>
    <script src="{{asset('js_admin/bundle.js')}}"></script>
    <script src="{{asset('js_admin/ajax.js')}}"></script>
    <script>
      // var classname = $('tr.table');
      // var id = '';
      // // INPUT
      // var mymap1
      // mymap1 = L.map('mapid',{
      //     center :  [-7.7520153,110.4892787],
      //     zoom: 13,
      // });
      // L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
      //     maxZoom: 20,
      //     minZoom: 13,
      //     subdomains:['mt0','mt1','mt2','mt3']
      // }).addTo(mymap1);
      // function getcenter1(){
      //     var center = mymap1.getCenter();
      //     document.getElementById("bujur").value = center.lng;
      //     document.getElementById("lintang").value = center.lat;
      // }

      // // EDIT
      // var mymap = [];
      // for (let i = 0; i < classname.length; i++) {
      //   id = $(classname[i]).attr('id');
      //   $.getJSON("/center/kecamatan/"+id+"", function (data1){
      //       mymap[id] = L.map("mapid"+id, {
      //           center: [data1.lintang,data1.bujur],
      //           zoom: 20,
      //           // scrollWheelZoom: false,
      //       });
      //       var geojsonLayer = new L.GeoJSON.AJAX("/batas/"+data1.batas,{
      //           fillOpacity : 0,
      //           color : 'white'
      //       });
      //       geojsonLayer.addTo(mymap[id]);
      //       L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
      //           maxZoom: 20,
      //           minZoom: 13,
      //           subdomains:['mt0','mt1','mt2','mt3']
      //       }).addTo(mymap[id]);
            
      //       // Marker Current
      //       var current = L.icon({
      //           iconUrl: '/gambar/marker/current.png',
      //           iconSize:     [17, 17], // size of the icon
      //           iconAnchor:   [5, 15], // point of the icon which will correspond to marker's location
      //           popupAnchor:  [-10, -5], // point from which the popup should open relative to the iconAnchor
      //           tooltipAnchor: [9,-20], //Alhamdulillah nemu bind tool up e aku :D
      //       });
      //       L.marker([data1.lintang,data1.bujur],{icon:current})
      //       .addTo(mymap[id])
      //       .bindPopup("Lokasi terkini");
      //   })
      // }
      // function getcenter2(id){
      //     var center = mymap[id].getCenter();   
      //     document.getElementById("bujur"+id+"").value = center.lng;
      //     document.getElementById("lintang"+id+"").value = center.lat;
      // }

    </script>
    <script src="{{asset('js_admin/crud_map.js')}}"></script>
@endsection