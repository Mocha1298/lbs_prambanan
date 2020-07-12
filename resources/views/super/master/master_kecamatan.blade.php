@extends('super.template')

@section('title','Master Kecamatan')

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
    Master Kecamatan
@endsection
@section('isi')
  <div class="isi">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <table>
      <caption>Tabel Kecamatan</caption>
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Nama Kecamatan</th>
          <th scope="col">Jumlah Desa</th>
        </tr>
      </thead>
      @if ($count != 0)
        <tbody>
          @foreach($data as $kc)
          <tr id="{{$kc->id}}" class="table">
            <td data-label="No">{{ $loop->iteration }}</td>
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
        <a style="color:white;" class="add" href="#add">Tambah Kecamatan</a>
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
          <form id="form" action="/master_kecamatan_ubah/{{$kc->id}}" method="post">
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
              <div onclick="getcenter2({{$kc->id}});" class="map" id="mapid{{$kc->id}}" style="width: 100%; height: 40vh;">
                <img class="marker" src="{{asset('gambar/marker/marker.png')}}" alt="">
              </div>
            <fieldset>
            <fieldset>
              <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Submit</button>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
    {{-- POPUP HAPUS DATA --}}
    <div id="popup_h{{$kc->id}}" class="overlay">
      <div class="popup">
        <h2>Hapus Data Kecataman?</h2>
        <div class="content">
          <fieldset class="acc">
            <a class="acc" href="/master_kecamatan_hapus/{{ $kc->id }}">HAPUS</a>
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
        <form id="form" action="/master_kecamatan_tambah" method="post">
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
            <div onclick="getcenter1();" id="mapid" style="width: 100%; height: 40vh;">
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