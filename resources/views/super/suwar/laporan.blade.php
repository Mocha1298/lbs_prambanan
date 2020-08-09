@extends('super.template')

@section('title','LAPORAN')

@section('head')
  <link rel="stylesheet" href="{{asset('style_admin/table.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/action.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/button.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/popup.css')}}">
  <link rel="stylesheet" href="{{asset('style_user/box-map.css')}}">
  <style>
    #mapid{
      width: 100%;
      height: 500px;
    }
  </style>
  <script src="{{asset('jquery/jquery.js')}}"></script>
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
    <table>
      <caption>Tabel Laporan</caption>
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Judul</th>
          <th scope="col">RT/RW</th>
          <th scope="col">Foto</th>
          <th scope="col">Tanggal Masuk</th>
          <th scope="col">Status</th>
        </tr>
      </thead>
      @if ($count != 0)
        <tbody>
          @foreach($data as $sw)
            <tr id="{{$sw->id}}" class="table">
              <td data-label="No">{{ $loop->iteration }}</td>
              <td data-label="Judul">{{ $sw->nama }}</td>
              <td data-label="RT/RW">{{ $sw->rt }}/{{ $sw->rw }}</td>
              <td data-label="Foto"><a href="/gambar/laporan/ori/{{$sw->foto1}}"><img src="/gambar/laporan/thumbnail/{{ $sw->foto1 }}" width="100px" height="auto"></a></td>
              <td data-label="Tanggal Masuk">{{ $sw->created_at }}</td>
              <td data-label="Status" style="color:white;background: @if($sw->status==1) dodgerblue @elseif($sw->status==2) forestgreen @else indianred @endif">@if($sw->status==1) Diterima @elseif($sw->status==2) Disetujui @else Ditunda @endif</td>
              {{-- Content Klik Kanan --}}
              @if ($sw->status == 1)
              <div id="contextMenu" class="cm_{{$sw->id}}" style="display: none">
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
                  <li class="detail">
                  <a href="/suwar_acc/{{$sw->id}}">SETUJU</a>
                  </li>
                  <li class="hapus">
                    <a href="/suwar_dis/{{$sw->id}}" >DITUNDA</a>
                  </li>
                </ul>
              </div>
              @endif
            </tr>
          @endforeach
        </tbody>
      @else
        <tbody>
          <tr>Data masih kosong!</tr>
        </tbody>
      @endif
    </table>
    <div class="pagination">
        <a style="right: 0; width: 50px;" href="#map"><i style="width: 28px; height: 28px; color: mediumseagreen;" class="fa fa-globe fa-2x"></i></a>
        <?php
          // config
          $link_limit = 5;
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
  {{-- POPUP MAP --}}
  <div id="map" class="overlay">
    <div class="popup">
      <h2>Peta Laporan</h2>
      <a href='#' class='close'>&times;</a>
      <div class="content">
        <div id="mapid"></div>
      </div>
    </div>
  </div>
@endsection
@section('script')
    <script src="{{asset('js_admin/action.js')}}"></script>
    <script src="{{asset('js_admin/bundle.js')}}"></script>
    <script src="{{asset('js_admin/polygon.js')}}"></script>
    <script>
      $.getJSON("/center_desa", function (data){
          mymap = L.map('mapid',{
              center :  [data.lintang,data.bujur],
              watch : true,
              zoom: 16,
              // scrollWheelZoom: false,
              closePopupOnClick: false
          });
          L.geoJSON([prambanan],{
              fillOpacity : 0,
              color : 'white'
          }).addTo(mymap);
          L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
              minZoom: 10,
              maxZoom: 20,
              subdomains:['mt0','mt1','mt2','mt3']
          }).addTo(mymap);
      });
      $.getJSON("/datapeta_desa", function (data1) {
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