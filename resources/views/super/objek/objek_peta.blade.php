@extends('super.template')

@section('title','Objek Peta')

@section('head')
  <link rel="stylesheet" href="{{asset('style_admin/table.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/form.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/action.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/alert.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/button.css')}}">
  <script src="{{asset('js_admin/nav.js')}}"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
  integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
  crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
  <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
@endsection
@section('copy')
oncopy='return false' oncut='return false' onpaste='return false'
@endsection
@section('breadcrump')
    @if (Auth::user()->roles_id != 2)
        Objek Peta
    @endif
    <a style="position: absolute; right: 0; width: 50px;" href="/peta_kerusakan"><i style="width: 28px; height: 28px; color: mediumseagreen;" class="fa fa-globe fa-2x"></i></a>
@endsection
@section('isi')
  <div class="isi">
    <table>
      <caption>Tabel Objek Peta</caption>
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Nama</th>
          <th scope="col">Kategori</th>
          <th scope="col">Foto</th>
        </tr>
      </thead>
      @if ($count != 0)
        <tbody>
          @foreach($data as $pt)
            <tr id="{{$pt->id}}" class="table">
              <td data-label="No">{{ $loop->iteration }}</td>
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
    <div class="pagination">
        <a style="color:white;" class="add" href="#add">Tambah Objek</a>
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
@endsection
@section('script')
    <script>
      function href() {
        window.location.href = '#';
      }
    </script>
    <script src="{{asset('js_admin/action.js')}}"></script>
    <script src="{{asset('js_admin/bundle.js')}}"></script>
    <script src="{{asset('js_admin/crud_map.js')}}"></script>
@endsection