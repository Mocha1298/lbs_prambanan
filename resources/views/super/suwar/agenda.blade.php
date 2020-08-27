@extends('super.template')

@section('title','AGENDA SURVEY')

@section('head')
  <link rel="stylesheet" href="{{asset('style_admin/table.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/popup.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/action.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/form.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/alert.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/button.css')}}">
  <link rel="stylesheet" href="{{asset('style_user/box-map.css')}}">
  <link rel="stylesheet" href="{{asset('bs/pagination.css')}}">
  <style>
    #mapid{
      width: 100%;
      height: 500px;
    }
  </style>
  <script src="{{asset('js_admin/nav.js')}}"></script>
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
        <a href="/master_kecamatan">Master Kecamatan</a> > <a href="/master_desa_back/{{$id}}">Master Kerusakan</a> >Data Kerusakan
    @endif
@endsection
@section('isi')
  <div class="isi">
    <a style="right: 0; width: 50px;" href="#map"><i style="width: 28px; height: 28px; color: mediumseagreen;" class="fa fa-globe fa-2x"></i></a>
    <table>
      <caption>Agenda Survey Laporan</caption>
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Judul</th>
          <th scope="col">RT/RW</th>
          <th scope="col">Foto</th>
          <th scope="col">Tanggal Survey</th>
          <th scope="col">Foto Survey</th>
        </tr>
      </thead>
      @if ($count != 0)
        <tbody>
          @foreach($data as $nomor => $sw)
            <tr id="{{$sw->id}}" class="table">
              <td data-label="No">{{ $nomor + $data->firstitem()}}</td>
                <td data-label="Judul">{{ $sw->nama }}</td>
                <td data-label="RT/RW">{{ $sw->rt }}/{{ $sw->rw }}</td>
                <td data-label="Foto"><a href="/gambar/laporan/ori/{{$sw->foto1}}"><img src="/gambar/laporan/thumbnail/{{ $sw->foto1 }}" width="100px" height="auto"></a></td>
                <td data-label="Tanggal Survey">{{$sw->survey}}</td>
                <td data-label="Foto Survey">
                  <a href="/gambar/survey/ori/{{$sw->photo}}">
                    <img src="/gambar/survey/thumbnail/{{$sw->photo}}" alt="" width="100px" height="auto"> 
                  </a>
                </td>
                {{-- Content Klik Kanan --}}
                <div id="contextMenu" class="cm_{{$sw->id}}" style="display: none">
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
                    <li class="edit">
                        <a href="#popup_s{{$sw->id}}">EDIT</a>
                    </li>
                    <li class="detail">
                        <a href="#popup_v{{$sw->id}}">VALID</a>
                    </li>
                    </ul>
                </div>
            </tr>
          @endforeach
        </tbody>
      @else
        <tbody>
          <tr>Data masih kosong!</tr>
        </tbody>
      @endif
    </table>
    {{$data->links()}}
  </div>
  {{-- SURVEY --}}
@foreach ($data as $sw)
  <div id="popup_s{{$sw->id}}" class="overlay">
    <div class="popup">
      <h2>Perbarui data</h2>
      <div class="content">
        <form id="form" action="/survey/{{$id}}" method="post">
          {{ csrf_field() }}
          <input type="reset" id="configreset" value="&times;" class="close" onclick="href();">
          <fieldset>
            <label for="">Tanggal Survey</label><br><br>
            <input placeholder="Tanggal Survey" type="date" autocomplete="off" name="survey" value="{{$sw->survey}}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
            <label style="font-size: 12px; color: #888;" for="survey"></label>
            @error('survey')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
          </fieldset>
          <fieldset>
            <label for="">Foto Survey</label>
            <input style="margin-top: 10px" type="file" id="fileimg1" accept="image/*" name="foto">
            <img style="margin-left: 20px" width="50px" height="auto" src="/gambar/survey/thumbnail/{{$sw->photo}}" alt="">
            @error('foto1')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
          </fieldset>
          <fieldset>
            <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Simpan</button>
          </fieldset>
      </form>
      </div>
    </div>
  </div>
  <div id="popup_v{{$sw->id}}" class="overlay">
    <div class="popup">
      <h2>MASUKKAN DATA KEDALAM KERUSAKAN?</h2>
      <div class="content">
        <fieldset class="acc">
          <a class="ya" href="/valid/{{ $sw->id }}">YA, MASUKKAN.</a>
          <a class="cancel" href="#">Batal</a>
        </fieldset>
      </div>
    </div>
  </div>
@endforeach
<div id="map" class="overlay">
  <div class="popup">
    <h2>Peta Agenda</h2>
    <a href="#" class="close">&times;</a>
    <div class="content">
      <div id="mapid"></div>
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
    <script src="{{asset('js_admin/bundle.js')}}"></script>
    <script src="{{asset('js_admin/ajax.js')}}"></script>
    <script>
      $.getJSON("/center_desa", function (data){
          mymap = L.map('mapid',{
              center :  [data.lintang,data.bujur],
              watch : true,
              zoom: 16,
              // scrollWheelZoom: false,
              closePopupOnClick: false
          });
          var geojsonLayer = new L.GeoJSON.AJAX("/batas/"+data.batas,{
              fillOpacity : 0,
              color : 'white'
          });       
          geojsonLayer.addTo(mymap);
          L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
              minZoom: 10,
              maxZoom: 20,
              subdomains:['mt0','mt1','mt2','mt3']
          }).addTo(mymap);
      });
      $.getJSON("/datapeta_agenda", function (data1) {
          for (var i = 0; i < data1.length; i++) {
            var name = data1[i].nama;
            L.marker([data1[i].lintang, data1[i].bujur])
            .addTo(mymap)
            .bindPopup(
                (info =
                    "<div class='cont'>"
                        +"<div class='box'>"
                            +"<div class='header'>"
                                +"<h2><strong> Nama Laporan : "+name+"</strong></h2>"
                                +"<p> Keterangan : "+data1[i].keterangan+"</p>"
                                +"<p>RT/RW : "+data1[i].rt+"/"+data1[i].rw+" </p>"
                                +"<p><strong>Tanggal Survey: "+data1[i].survey+"</strong></p>"
                            +"</div>"
                            +"<img src='/gambar/laporan/thumbnail/"+data1[i].foto1+"' alt=''>"
                        +"</div>"
                    +"</div>"
                    )
            );
          }
      })
    </script>
@endsection