@extends('super.template')

@section('title','OBJEK KERUSAKAN')

@section('head')
  {{-- OK BOSSS --}}
  <link rel="stylesheet" href="{{asset('style_admin/table.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/form.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/action.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/alert.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/button.css')}}">
  <link rel="stylesheet" href="{{asset('style_user/box-map.css')}}">
  <script src="{{asset('js_admin/nav.js')}}"></script>
  <script src="{{asset('jquery/jquery.js')}}"></script>
  <style>
    #peta{
      width: 100%;
      height: 500px;
    }
  </style>
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
        <a href="/master_kecamatan">{{$kc->nama}}</a> > <a href="/master_desa/{{$ids}}">{{$vil->nama}}</a>
    @else
    Data Kerusakan
    @endif
@endsection
@section('isi')
  <div class="isi">
    <table>
      <caption>Tabel Kerusakan</caption>
      <a style="right: 0; width: 50px;" href="#map"><i style="width: 28px; height: 28px; color: mediumseagreen;" class="fa fa-globe fa-2x"></i></a>
      <thead>
        <tr>
          <th scope="col">Nama</th>
          <th scope="col">Sumber</th>
          <th scope="col">Level</th>
          <th scope="col">Status</th>
          <th scope="col">Tanggal</th>
          <th scope="col">RT/RW</th>
          <th scope="col">Foto</th>
        </tr>
      </thead>
      @if ($count != 0)
        <tbody>
          @foreach($data as $kr)
            <tr id="{{$kr->id}}" class="table">
              <td data-label="Nama" class="titik">{{ $kr->nama }}</td>
              <td data-label="Sumber">@if($kr->sumber == 1) RPJMD @else SUARA WARGA @endif</td>
              <td data-label="Level">{{ $kr->level }}</td>
              <td data-label="Status">{{ $kr->status }}</td>
              <td data-label="Tanggal">{{ $kr->perbaikan }}</td>
              <td data-label="RT/RW">{{ $kr->rt }}/{{ $kr->rw }}</td>
              <td data-label="Foto">
                @if ($kr->status == 'Rencana')
                <a href="/gambar/kerusakan/ori/{{$kr->foto1}}"><img src="/gambar/kerusakan/thumbnail/{{$kr->foto1}}" alt="" width="50px" height="auto"></a>
                @elseif ($kr->status == 'Sedang')
                <a href="/gambar/kerusakan/ori/{{$kr->foto1}}"><img src="/gambar/kerusakan/thumbnail/{{$kr->foto1}}" alt="" width="50px" height="auto"></a>
                <a href="/gambar/kerusakan/ori/{{$kr->foto2}}"><img src="/gambar/kerusakan/thumbnail/{{$kr->foto2}}" alt="" width="50px" height="auto"></a>
                @elseif ($kr->status == 'Selesai')
                <a href="/gambar/kerusakan/ori/{{$kr->foto1}}"><img src="/gambar/kerusakan/thumbnail/{{$kr->foto1}}" alt="" width="50px" height="auto"></a>
                <a href="/gambar/kerusakan/ori/{{$kr->foto2}}"><img src="/gambar/kerusakan/thumbnail/{{$kr->foto2}}" alt="" width="50px" height="auto"></a>
                <a href="/gambar/kerusakan/ori/{{$kr->foto3}}"><img src="/gambar/kerusakan/thumbnail/{{$kr->foto3}}" alt="" width="50px" height="auto"></a>
                @endif
              </td>
                {{-- Content Klik Kanan --}}
                <div id="contextMenu" class="cm_{{$kr->id}}" style="display: none">
                  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
                    <li class="edit">
                      <a href="#popup_e{{$kr->id}}">EDIT</a>
                    </li>
                    <li class="hapus">
                      <a href="#popup_h{{$kr->id}}" >HAPUS</a>
                    </li>
                    <li class="detail">
                      <a href="#popup_s{{$kr->id}}">STATUS</a>
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
    <div class="pagination">
        <a style="color:white;" class="add" href="#add">Tambah</a>
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
  @foreach ($data as $kr)
    {{-- POPUP EDIT DATA --}}
    <div id="popup_e{{$kr->id}}" class="overlay">
      <div class="popup">
        <h2>Edit Desa</h2>
        <div class="content">
          <form id="form" action="/objek_kerusakan_ubah/{{$kr->id}}" method="post" enctype="multipart/form-data">
            <input type="reset" id="configreset" value="&times;" class="close" onclick="href();">
            {{ csrf_field() }}
            <fieldset>
              <input placeholder="Nama Kerusakan" type="text" autocomplete="off" name="nama" value="{{ old('nama') ?? $kr->nama }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" autofocus>
              @error('nama')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror 
            </fieldset>
            <fieldset>
              <input placeholder="RT" type="text" autocomplete="off" name="rt" value="{{ old('rt') ?? $kr->rt }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" autofocus>
              @error('rt')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror 
            </fieldset>
            <fieldset>
              <input placeholder="RW" type="text" autocomplete="off" name="rw" value="{{ old('rw') ?? $kr->rw }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" autofocus>
              @error('rw')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror 
            </fieldset>
            <fieldset>
              <select name="level" id="form" tabindex="2" required>
                <option @if (old('level')=='') selected @endif value="">-- PILIH LEVEL--</option>
                <option @if (old('level')=='Ringan' || $kr->level == 'Ringan') selected @endif value="Ringan">Ringan</option>
                <option @if (old('level')=='Berat' || $kr->level == 'Berat') selected @endif value="Berat">Berat</option>
              </select>
              @error('level')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <fieldset>
              <input type="date" autocomplete="off" name="perbaikan" value="{{ old('perbaikan') ?? $kr->perbaikan }}" tabindex="3" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
              <label style="font-size: 12px; color: #888;" for="perbaikan">Rencana Perbaikan</label>
              @error('perbaikan')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            @if ($kr->status == 'Rencana')
              <fieldset>
                <label for="">Foto Kerusakan</label>
                <input style="margin-top: 10px" type="file" id="fileimg1" accept="image/*" name="foto1">
                <img style="margin-left: 20px" width="50px" height="auto" src="/gambar/kerusakan/thumbnail/{{$kr->foto1}}" alt="">
                @error('foto1')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
              </fieldset>
            @endif
            @if($kr->status == 'Sedang')
              <fieldset>
                  <label for="">Foto Kerusakan</label>
                  <input style="margin-top: 10px" type="file" id="fileimg1" accept="image/*" name="foto1">
                  <img style="margin-left: 20px" width="50px" height="auto" src="/gambar/kerusakan/thumbnail/{{$kr->foto1}}" alt="">  
                  @error('foto1')
                  <div class="invalid-feedback">
                      {{$message}}
                  </div>
                  @enderror
              </fieldset>
              <fieldset>
                  <label for="">Foto Perbaikan</label>
                  <input style="margin-top: 10px" type="file" id="fileimg1" accept="image/*" name="foto2">
                  <img style="margin-left: 20px" width="50px" height="auto" src="/gambar/kerusakan/thumbnail/{{$kr->foto2}}" alt="">
                  @error('foto2')
                  <div class="invalid-feedback">
                      {{$message}}
                  </div>
                  @enderror
              </fieldset>
            @endif
            @if($kr->status == 'Selesai')
              <fieldset>
                  <label for="">Foto Kerusakan</label>
                  <input style="margin-top: 10px" type="file" id="fileimg1" accept="image/*" name="foto1">
                  <img style="margin-left: 20px" width="50px" height="auto" src="/gambar/kerusakan/thumbnail/{{$kr->foto1}}" alt="">
                  @error('foto1')
                  <div class="invalid-feedback">
                      {{$message}}
                  </div>
                  @enderror
              </fieldset>
              <fieldset>
                  <label for="">Foto Perbaikan</label>
                  <input style="margin-top: 10px" type="file" id="fileimg1" accept="image/*" name="foto2">
                  <img style="margin-left: 20px" width="50px" height="auto" src="/gambar/kerusakan/thumbnail/{{$kr->foto2}}" alt="">
                  @error('foto2')
                  <div class="invalid-feedback">
                      {{$message}}
                  </div>
                  @enderror
              </fieldset>
              <fieldset>
                  <label for="">Foto Selesai</label>
                  <input style="margin-top: 10px" type="file" id="fileimg1" accept="image/*" name="foto3">
                  <img style="margin-left: 20px" width="50px" height="auto" src="/gambar/kerusakan/thumbnail/{{$kr->foto3}}" alt="">
                  @error('foto3')
                  <div class="invalid-feedback">
                      {{$message}}
                  </div>
                  @enderror
              </fieldset>
            @endif
            <fieldset>
              <input id="bujur{{$kr->id}}" placeholder="Longitude" type="text" name="bujur" value="{{ old('bujur') ?? $kr->bujur }}" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" readonly>
              @error('bujur')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <fieldset>
              <input id="lintang{{$kr->id}}" placeholder="Latitude" type="text" name="lintang" value="{{ old('lintang') ?? $kr->lintang }}" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" readonly>
              @error('lintang')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <fieldset>
            <div onmousemove="getcenter2({{$kr->id}});" class="map" id="mapid{{$kr->id}}" style="width: 100%; height: 40vh;">
                <img class="marker" src="{{asset('gambar/marker/marker.png')}}" alt="">
              </div>
            <fieldset>
            <fieldset>
              <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Simpan</button>
            </fieldset>
            <fieldset>
              <a id="cancel" href="/objek_kerusakan/{{$id}}">Cancel</a>
            </fieldset>
        </form>
        </div>
      </div>
    </div>
    {{-- POPUP HAPUS DATA --}}
    <div id="popup_h{{$kr->id}}" class="overlay">
      <div class="popup">
        <h2>Hapus Data Kerusakan?</h2>
        <div class="content">
          <fieldset class="acc">
            <a class="acc" href="/objek_kerusakan_hapus/{{ $kr->id }}">HAPUS</a>
            <a class="cancel" href="#">Batal</a>
          </fieldset>
        </div>
      </div>
    </div>
    {{-- POPUP STATUS --}}
    <div id="popup_s{{$kr->id}}" class="overlay">
      <div class="popup">
        <h2>Ubah Status Perbaikan</h2>
        <div class="content">
          <form method="post" id="form" action="/objek_kerusakan_status/{{$kr->id}}">
            {{ csrf_field() }}
            <input type="reset" id="configreset" value="&times;" class="close" onclick="href();">
            <fieldset>
              <select name="kategori" id="form">
                @foreach ($tipe as $item)
                  <option value="{{$item->id}}"
                  @if (old('kategori') == '')
                    @if ($kr->types_id == $item->id)
                        selected
                    @endif
                  @elseif(old('kategori') == $item->id)  
                      selected
                  @endif
                  >{{$item->nama}}</option>
                @endforeach
              </select>
            </fieldset>
            <fieldset>
              <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Simpan</button>
            </fieldset>
            <fieldset>
              <a id="cancel" href="/objek_kerusakan/{{$id}}">Cancel</a>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  @endforeach
  <div id="add" class="overlay">
    <div class="popup">
      <h2>Tambah Data</h2>
      <div class="content">
        <form id="form" action="/objek_kerusakan_tambah/{{$id}}" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <input type="reset" id="configreset" value="&times;" class="close" onclick="href();">
          {{-- @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif --}}
          <fieldset>
            <input placeholder="Nama Kerusakan" type="text" autocomplete="off" name="nama" value="{{ old('nama') }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" autofocus>
            @error('nama')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror 
          </fieldset>
          <fieldset>
            <input placeholder="RT" type="text" autocomplete="off" name="rt" value="{{ old('rt') }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" autofocus>
            @error('rt')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror 
          </fieldset>
          <fieldset>
            <input placeholder="RW" type="text" autocomplete="off" name="rw" value="{{ old('rw') }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" autofocus>
            @error('rw')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror 
          </fieldset>
          <fieldset>
            <select name="level" id="form" tabindex="2" required>
              <option @if (old('level')=='') selected @endif value="">-- PILIH LEVEL--</option>
              <option @if (old('level')=='Ringan') selected @endif value="Ringan">Ringan</option>
              <option @if (old('level')=='Berat') selected @endif value="Berat">Berat</option>
            </select>
            @error('level')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
          </fieldset>
          <fieldset>
            <input placeholder="Rencana Perbaikan" type="date" autocomplete="off" name="perbaikan" value="{{ old('perbaikan') }}" tabindex="5" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
            <label style="font-size: 12px; color: #888;" for="perbaikan">Rencana Perbaikan</label>
            @error('perbaikan')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
          </fieldset>
          <fieldset>
            <input style="margin-top: 10px" type="file" id="fileimg1" accept="image/*" name="foto1">
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
            <a id="cancel" href="/objek_kerusakan/{{$id}}">Cancel</a>
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
      var input = "kerusakan";
      var desa = {{$vil->id}};
    </script>
    <script src="{{asset('js_admin/action.js')}}"></script>
    <script src="{{asset('js_admin/bundle.js')}}"></script>
    <script src="{{asset('js_admin/ajax.js')}}"></script>
    <script src="{{asset('js_admin/crud_map.js')}}"></script>
    <script>
      $.getJSON("/center/desa/"+desa, function (db){
          mymap = L.map('peta',{
              center :  [db.lintang,db.bujur],
              watch : true,
              zoom: 14,
              // scrollWheelZoom: false,
              closePopupOnClick: false
          });
          var geojsonLayer = new L.GeoJSON.AJAX("/batas/"+db.batas,{
              fillOpacity : 0,
              color : 'white'
          });       
          geojsonLayer.addTo(mymap);
          L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{
            maxZoom: 20,
            minZoom: 13,
            subdomains:['mt0','mt1','mt2','mt3']
          }).addTo(mymap);
      });
      $.getJSON("/datapeta_kr", function (marker) {
          for (var i = 0; i < marker.length; i++) {
              var icon = L.icon({
                  iconUrl: '/gambar/jenis/'+marker[i].marker,
                  iconSize:     [30, 30],
              });
              var name = marker[i].kerusakan;
              var status = marker[i].status;
              kerusakan[i] = L.marker([marker[i].lintang, marker[i].bujur],{icon: icon})
              .addTo(mymap)
              .bindPopup(
                  (info =
                      "<div class='cont'>"
                          +"<div class='box'>"
                              +"<div class='header'>"
                                  +"<h2><strong>"+name+"</strong></h2>"
                                  +"<p>Desa : "+marker[i].desa+" </p>"
                                  +"<p>RT/RW : "+marker[i].rt+"/"+marker[i].rw+" </p>"
                              +"</div>"
                              +"<img src='/gambar/kerusakan/thumbnail/"
                              +(status == 'Rencana' ? marker[i].foto1 : "")
                              +(status == 'Sedang' ? marker[i].foto2 : "")
                              +(status == 'Selesai' ? marker[i].foto3 : "")
                              +"' alt=''>"
                              +"<a id='jos' onclick='return show("+marker[i].id+");'>Detail<i class='fa fa-arrow-circle-right'></a>"
                              +"</a>"
                          +"</div>"
                      +"</div>"
                      )
              );
          }
      })
    </script>
@endsection