@extends('super.template')

@section('title','Master Kecamatan')

@section('head')
  <link rel="stylesheet" href="{{asset('style_admin/table.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/popup.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/form.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/action.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/alert.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/button.css')}}">
  <script src="{{asset('jquery/jquery-3.5.1.slim.min.js')}}"></script>
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
    <table>
      <caption>Tabel Kecamatan</caption>
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Nama Kecamatan</th>
          <th scope="col">Jumlah Desa</th>
          <th scope="col">Nama Kepala Camat</th>
        </tr>
      </thead>
      @if ($count != 0)
        <tbody>
          @foreach($data as $kc)
          <tr id="{{$kc->id}}" class="table">
            <td data-label="No">{{ $loop->iteration }}</td>
            <td data-label="Nama Kecamatan">{{ $kc->nama }}</td>
            <td data-label="Jumlah Desa">{{ $kc->desa }}</td>
            <td data-label="Nama Kepala Camat">{{ $kc->nama_cmt }}</td>
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
          <tr>Belum ada data! Tambah sekarang...</tr>
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
        <a class="close" href="/master_kecamatan">&times;</a>
        <div class="content">
        <form id="form" action="/master_kecamatan_ubah/{{$kc->id}}" method="post">
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
              <input placeholder="Nama Camat" type="text" name="nama_cmt" value="{{ old('nama_cmt') ?? $kc->nama_cmt }}" tabindex="1"  oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
              @error('nama_cmt')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <fieldset>
              <input id="bujur" placeholder="Longitude" type="text" name="bujur" value="{{ old('bujur') ?? $kc->bujur }}" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" readonly>
              @error('bujur')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <fieldset>
              <input id="lintang" placeholder="Latitude" type="text" name="lintang" value="{{ old('lintang') ?? $kc->lintang}}" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" readonly>
              @error('lintang')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <div id="mapid2" style="width: 100%; height: 40vh;"></div>
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
      <a class="close" href="#">&times;</a>
      <div class="content">
        <form id="form" action="/master_kecamatan_tambah" method="post">
          {{ csrf_field() }}
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
            <input placeholder="Nama Camat" autocomplete="off" type="text" name="nama_cmt" value="{{ old('nama_cmt') }}" tabindex="3" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
            @error('nama_cmt')
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
          <div id="mapid1" style="width: 100%; height: 40vh;"></div>
          <fieldset>
            <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Simpan</button>
          </fieldset>
      </form>
      </div>
    </div>
  </div>
@endsection
@section('script')
    <script src="{{asset('js_admin/action.js')}}"></script>
    <script src="{{asset('js_admin/bundle.js')}}"></script>
    <script src="{{asset('js_admin/edit_map.js')}}"></script>
    <script src="{{asset('js_admin/input_map.js')}}"></script>
@endsection