@extends('super.template')

@section('title','Master Jenis')

@section('head')
  <link rel="stylesheet" href="{{asset('style_admin/table.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/popup.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/form.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/action.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/alert.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/button.css')}}">
  <script src="{{asset('jquery/jquery-3.5.1.slim.min.js')}}"></script>
  <script src="{{asset('js_admin/nav.js')}}"></script>
@endsection
@section('copy')
oncopy='return false' oncut='return false' onpaste='return false'
@endsection
@section('breadcrump')
    Master Jenis
@endsection
@section('isi')
  <div class="isi">
    <table>
      <caption>Tabel Jenis</caption>
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Jenis</th>
          <th scope="col">Kategori</th>
          <th scope="col">Icon</th>
        </tr>
      </thead>
      <tbody>
        @foreach($data as $dt)
          <tr id="{{$dt->id}}" class="table">
            <td data-label="No">{{ $loop->iteration }}</td>
            <td data-label="Jenis">{{ $dt->jenis }}</td>
            <td data-label="Kategori">{{ $dt->kategori }}</td>
          <td data-label="Icon"><img width="50px" height="50px" src="{{asset('gambar/jenis/'.$dt->marker.'')}}" alt=""></td>
              {{-- Content Klik Kanan --}}
              <div id="contextMenu" class="cm_{{$dt->id}}" style="display: none">
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
                  <li class="edit">
                    <a href="#popup_e{{$dt->id}}">EDIT</a>
                  </li>
                  <li class="hapus">
                    <a href="#popup_h{{$dt->id}}">HAPUS</a>
                  </li>
                </ul>
              </div>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="pagination">
        <a style="color:white;" class="add" href="#add">Tambah Jenis</a>
        <?php
          // config
          $link_limit = 7; // maximum number of links (a little bit inaccurate, but will be ok for now)
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
  @foreach ($data as $dt)
    {{-- POPUP EDIT DATA --}}
    <div id="popup_e{{$dt->id}}" class="overlay">
      <div class="popup">
        <h2>Edit Data Jenis</h2>
        <a class="close" href="/master_jenis">&times;</a>
        <div class="content">
          <form id="form" action="/master_jenis_ubah/{{$dt->id}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <fieldset>
              <input placeholder="Kategori" type="text" name="nama" value="{{ $dt->nama ?? old('nama') }}" tabindex="2" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
              @error('nama')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <fieldset>
              <select name="jenis" id="form" required>
                <option @if ($dt->jenis=='' || old('jenis')=='') selected @endif value="">-- PILIH --</option>
                <option @if ($dt->jenis=='Kerusakan' || old('jenis')=='Kerusakan') selected @endif value="Kerusakan">Objek Kerusakan</option>
                <option @if ($dt->jenis=='Peta' || old('jenis')=='Peta') selected @endif value="Peta">Objek Peta</option>
              </select>
              @error('jenis')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <fieldset>
              <input type="file" id="fileimg1" accept="image/*" name="marker">
              <input type="text" name="marker1" hidden value="{{$dt->marker ?? old('marker1')}}">
              <img src="{{asset('gambar/jenis/'.$dt->marker)}}" alt="">
            </fieldset>
            <fieldset>
              <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Simpan</button>
            </fieldset>
        </form>
        </div>
      </div>
    </div>
    {{-- POPUP HAPUS DATA --}}
    <div id="popup_h{{$dt->id}}" class="overlay">
      <div class="popup">
        <h2>Hapus Data Jenis?</h2>
        <div class="content">
          <fieldset class="acc">
            <a class="acc" href="/master_jenis_hapus/{{ $dt->id }}">HAPUS</a>
            <a class="cancel" href="#">BATAL</a>
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
        <form id="form" action="/master_jenis_tambah" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <fieldset>
            <input placeholder="Kategori" type="text" autocomplete="off" name="nama" value="{{ old('nama') }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
            @error('nama')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
          </fieldset>
          <fieldset>
            <select name="jenis" id="form" required>
              <option @if (old('jenis')=='') selected @endif value="">-- PILIH --</option>
              <option @if (old('jenis')=='Kerusakan') selected @endif value="Kerusakan">Objek Kerusakan</option>
              <option @if (old('jenis')=='Peta') selected @endif value="Peta">Objek Peta</option>
            </select>
            @error('jenis')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
          </fieldset>
          <fieldset>
            <input type="file" id="fileimg" accept="image/*" name="marker" required>
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
    <script src="{{asset('js_admin/action.js')}}"></script>
@endsection