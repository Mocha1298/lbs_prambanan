@extends('super.template')

@section('title','Data Kerusakan')

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
    @if (Auth::user()->roles_id != 2)
        <a href="/master_kecamatan">Master Kecamatan</a> > <a href="/master_desa_back/{{$id}}">Master Kerusakan</a> >Data Kerusakan
    @endif
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
          @foreach($data as $sw)
            <tr id="{{$sw->id}}" class="table">
              <td data-label="No">{{ $loop->iteration }}</td>
              <td data-label="Nama">{{ $sw->nama }}</td>
              <td data-label="Level">{{ $sw->level }}</td>
              <td data-label="Status">{{ $sw->status }}</td>
              <td data-label="Tanggal">{{ $sw->perbaikan }}</td>
              <td data-label="RT/RW">{{ $sw->rt }}/{{ $sw->rw }}</td>
              <td data-label="Foto">
                @if ($sw->status == 'Rencana')
                <a href="/gambar/kerusakan/ori/{{$sw->foto1}}"><img src="/gambar/kerusakan/thumbnail/{{$sw->foto1}}" alt="" width="50px" height="auto"></a>
                @elseif ($sw->status == 'Sedang')
                <a href="/gambar/kerusakan/ori/{{$sw->foto1}}"><img src="/gambar/kerusakan/thumbnail/{{$sw->foto1}}" alt="" width="50px" height="auto"></a>
                <a href="/gambar/kerusakan/ori/{{$sw->foto2}}"><img src="/gambar/kerusakan/thumbnail/{{$sw->foto2}}" alt="" width="50px" height="auto"></a>
                @elseif ($sw->status == 'Selesai')
                <a href="/gambar/kerusakan/ori/{{$sw->foto1}}"><img src="/gambar/kerusakan/thumbnail/{{$sw->foto1}}" alt="" width="50px" height="auto"></a>
                <a href="/gambar/kerusakan/ori/{{$sw->foto2}}"><img src="/gambar/kerusakan/thumbnail/{{$sw->foto2}}" alt="" width="50px" height="auto"></a>
                <a href="/gambar/kerusakan/ori/{{$sw->foto3}}"><img src="/gambar/kerusakan/thumbnail/{{$sw->foto3}}" alt="" width="50px" height="auto"></a>
                @endif
              </td>
                {{-- Content Klik Kanan --}}
                <div id="contextMenu" class="cm_{{$sw->id}}" style="display: none">
                  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
                    <li class="edit">
                      <a href="#popup_e{{$sw->id}}">EDIT</a>
                    </li>
                    <li class="hapus">
                      <a href="#popup_h{{$sw->id}}" >HAPUS</a>
                    </li>
                    <li class="detail">
                      <a href="#popup_s{{$sw->id}}">STATUS</a>
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
        <a style="right: 0; width: 50px;" href="/peta_kerusakan/{{$id}}"><i style="width: 28px; height: 28px; color: mediumseagreen;" class="fa fa-globe fa-2x"></i></a>
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
  @foreach ($data as $sw)
    {{-- POPUP EDIT DATA --}}
    <div id="popup_e{{$sw->id}}" class="overlay">
      <div class="popup">
        <h2>Edit Desa</h2>
        <div class="content">
          <form id="form" action="/objek_kerusakan_ubah/{{$sw->id}}" method="post" enctype="multipart/form-data">
            <a class="close" href="/objek_kerusakan/{{$sw->villages_id}}">&times;</a>
            {{ csrf_field() }}
            <fieldset>
              <input placeholder="Nama Kerusakan" type="text" autocomplete="off" name="nama" value="{{ old('nama') ?? $sw->nama }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" autofocus>
              @error('nama')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror 
            </fieldset>
            <fieldset>
              <input placeholder="RT" type="text" autocomplete="off" name="rt" value="{{ old('rt') ?? $sw->rt }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" autofocus>
              @error('rt')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror 
            </fieldset>
            <fieldset>
              <input placeholder="RW" type="text" autocomplete="off" name="rw" value="{{ old('rw') ?? $sw->rw }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" autofocus>
              @error('rw')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror 
            </fieldset>
            <fieldset>
              <select name="level" id="form" tabindex="2" required>
                <option @if (old('level')=='') selected @endif value="">-- PILIH LEVEL--</option>
                <option @if (old('level')=='Ringan' || $sw->level == 'Ringan') selected @endif value="Ringan">Ringan</option>
                <option @if (old('level')=='Berat' || $sw->level == 'Berat') selected @endif value="Berat">Berat</option>
              </select>
              @error('level')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <fieldset>
              <input type="date" autocomplete="off" name="perbaikan" value="{{ old('perbaikan') ?? $sw->perbaikan }}" tabindex="3" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
              <label style="font-size: 12px; color: #888;" for="perbaikan">Rencana Perbaikan</label>
              @error('perbaikan')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
              @if ($sw->status == 'Rencana')
              <fieldset>
                <label for="">Foto Kerusakan</label>
                <input style="margin-top: 10px" type="file" id="fileimg1" accept="image/*" name="foto1">
                <img style="margin-left: 20px" width="50px" height="auto" src="/gambar/kerusakan/thumbnail/{{$sw->foto1}}" alt="">
                @error('foto1')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
              </fieldset>
              @endif
              @if($sw->status == 'Sedang')
              <fieldset>
                <label for="">Foto Kerusakan</label>
                <input style="margin-top: 10px" type="file" id="fileimg1" accept="image/*" name="foto1">
                <img style="margin-left: 20px" width="50px" height="auto" src="/gambar/kerusakan/thumbnail/{{$sw->foto1}}" alt="">  
                @error('foto1')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
              </fieldset>
              <fieldset>
                <label for="">Foto Perbaikan</label>
                <input style="margin-top: 10px" type="file" id="fileimg1" accept="image/*" name="foto2">
                <img style="margin-left: 20px" width="50px" height="auto" src="/gambar/kerusakan/thumbnail/{{$sw->foto2}}" alt="">
                @error('foto2')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
              </fieldset>
              @endif
              @if($sw->status == 'Selesai')
              <fieldset>
                <label for="">Foto Kerusakan</label>
                <input style="margin-top: 10px" type="file" id="fileimg1" accept="image/*" name="foto1">
                <img style="margin-left: 20px" width="50px" height="auto" src="/gambar/kerusakan/thumbnail/{{$sw->foto1}}" alt="">
                @error('foto1')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
              </fieldset>
              <fieldset>
                <label for="">Foto Perbaikan</label>
                <input style="margin-top: 10px" type="file" id="fileimg1" accept="image/*" name="foto2">
                <img style="margin-left: 20px" width="50px" height="auto" src="/gambar/kerusakan/thumbnail/{{$sw->foto2}}" alt="">
                @error('foto2')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
              </fieldset>
              <fieldset>
                <label for="">Foto Selesai</label>
                <input style="margin-top: 10px" type="file" id="fileimg1" accept="image/*" name="foto3">
                <img style="margin-left: 20px" width="50px" height="auto" src="/gambar/kerusakan/thumbnail/{{$sw->foto3}}" alt="">
                @error('foto3')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
              </fieldset>
              @endif
            <fieldset>
              <input id="bujur{{$sw->id}}" placeholder="Longitude" type="text" name="bujur" value="{{ old('bujur') ?? $sw->bujur }}" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" readonly>
              @error('bujur')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <fieldset>
              <input id="lintang{{$sw->id}}" placeholder="Latitude" type="text" name="lintang" value="{{ old('lintang') ?? $sw->lintang }}" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" readonly>
              @error('lintang')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <fieldset>
            <div onclick="getcenter2({{$sw->id}});" class="map" id="mapid{{$sw->id}}" style="width: 100%; height: 40vh;">
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
    <div id="popup_h{{$sw->id}}" class="overlay">
      <div class="popup">
        <h2>Hapus Data Kerusakan?</h2>
        <div class="content">
          <fieldset class="acc">
            <a class="acc" href="/objek_kerusakan_hapus/{{ $sw->id }}">HAPUS</a>
            <a class="cancel" href="#">Batal</a>
          </fieldset>
        </div>
      </div>
    </div>
    {{-- POPUP STATUS --}}
    <div id="popup_s{{$sw->id}}" class="overlay">
      <div class="popup">
        <h2>Ubah Status Perbaikan</h2>
        <a class="close" href="/objek_kerusakan/{{$sw->villages_id}}">&times;</a>
        <div class="content">
          <form method="post" id="form" action="/objek_kerusakan_status/{{$sw->id}}">
            {{ csrf_field() }}
            <fieldset>
              <select name="kategori" id="form">
                @foreach ($tipe as $item)
                  <option value="{{$item->id}}"
                  @if (old('kategori') == '')
                    @if ($sw->types_id == $item->id)
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
            <div onclick="getcenter1();" id="mapid" style="width: 100%; height: 35vh;">
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