@extends('super.template')

@section('title','Master Kerusakan')

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
    <a href="/master_kecamatan">Master Kecamatan</a> > <a href="/master_desa_back/{{$id}}">Master Kerusakan</a> >Data Kerusakan
    <a style="position: absolute; right: 0; width: 50px;" href="/peta_kerusakan/{{$id}}"><i style="width: 28px; height: 28px; color: mediumseagreen;" class="fa fa-globe fa-2x"></i></a>
@endsection
@section('isi')
  <div class="isi">
    <table>
      <caption>Tabel Kerusakan</caption>
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Nama</th>
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
              <td data-label="No">{{ $loop->iteration }}</td>
              <td data-label="Nama">{{ $kr->nama }}</td>
              <td data-label="Level">{{ $kr->level }}</td>
              <td data-label="Status">{{ $kr->kategori }}</td>
              <td data-label="Tanggal">{{ $kr->perbaikan }}</td>
              <td data-label="RT/RW">{{ $kr->rt }}/{{ $kr->rw }}</td>
              <td data-label="Foto"><img src="../gambar/jenis/jenis_1592311483.png" alt="" width="50px" height="auto"></td>
                {{-- Content Klik Kanan --}}
                <div id="contextMenu" class="cm_{{$kr->id}}" style="display: none">
                  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
                    <li class="edit">
                      <a href="#popup_e{{$kr->id}}">EDIT</a>
                    </li>
                    <li class="hapus">
                      <a href="#popup_h{{$kr->id}}">HAPUS</a>
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
        <a style="color:white;" class="add" href="#add">Tambah Kerusakan</a>
        <?php
          // config
          $link_limit = 10;
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
        <h2>Edit Data Desa</h2>
        <a class="close" href="/objek_kerusakan/{{$kr->id}}">&times;</a>
        <div class="content">
          <form id="form" action="/objek_kerusakan_ubah/{{$kr->id}}" method="post">
            {{ csrf_field() }}
            <fieldset>
              <input placeholder="Nama Desa" type="text" name="nama" value="{{ old('nama') ?? $kr->nama }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" autofocus>
              @error('nama')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <fieldset>
              <input placeholder="Jumlah RW" type="text" name="rw" value="{{ old('rw') ?? $kr->rw }}" tabindex="2" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
              @error('rw')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <fieldset>
              <input id="bujur2" placeholder="Longitude" type="text" name="bujur" value="{{ old('bujur') ?? $kr->bujur }}" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" readonly>
              @error('bujur')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <fieldset>
              <input id="lintang2" placeholder="Latitude" type="text" name="lintang" value="{{ old('lintang') ?? $kr->lintang}}" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" readonly>
              @error('lintang')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <div id="mapid2" style="width: 100%; height: 40vh;"></div>
            <fieldset>
              <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Simpan</button>
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
  @endforeach
  <div id="add" class="overlay">
    <div class="popup">
      <h2>Form Tambah Data</h2>
      <a class="close" href="#">&times;</a>
      <div class="content">
        <form id="form" action="/objek_kerusakan_tambah/{{$id}}" method="post">
          {{ csrf_field() }}
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
            <input id="bujur1" placeholder="Longitude" type="text" autocomplete="off" name="bujur" value="{{ old('bujur') }}" tabindex="2" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" readonly>
            @error('bujur')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
          </fieldset>
          <fieldset>
            <input id="lintang1" placeholder="Latitude" type="text" name="lintang" value="{{ old('lintang') }}" tabindex="2" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" readonly>
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