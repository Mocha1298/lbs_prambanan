@extends('super.template')

@section('title','PENGGUNA')

@section('head')
  <link rel="stylesheet" href="{{asset('style_admin/table.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/form.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/action.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/alert.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/button.css')}}">
  <style>
      .main .pagination a.button{
        color: black;
        background-color: #d95235;
        padding: 5px 10px;
        border-radius: 15px;
        -webkit-box-shadow: 4px 4px 5px 1px #ccc;
        -moz-box-shadow:    4px 4px 5px 1px #ccc;
        box-shadow:         4px 4px 5px 1px #ccc;
      }
  </style>
  <script src="{{asset('js_admin/nav.js')}}"></script>
@endsection
@section('copy')
oncopy='return false' oncut='return false' onpaste='return false'
@endsection
@section('breadcrump')
    Master User
@endsection
@section('isi')
  <div class="isi">
    <table>
      <caption>Tabel User</caption>
      <thead>
        <tr>
          <th scope="col">Nama User</th>
          <th scope="col">Posisi</th>
          <th scope="col">Desa</th>
          <th scope="col">Email</th>
          <th scope="col">Status</th>
        </tr>
      </thead>
      @if ($count != 0)
        <tbody>
          @foreach($data as $us)
          <tr id="{{$us->id}}" class="table">
            <td data-label="Nama User" class="titik">{{ $us->nama }}</td>
            <td data-label="Posisi">
            @if ($us->roles_id == 1)
                Kecamatan
            @elseif($us->roles_id == 2)
                Desa
            @else
                Warga
            @endif
            </td>
            <td data-label="Desa" class="titik">{{ $us->desa }}</td>
            <td data-label="Email" class="titik">{{ $us->email }}</td>
            <td data-label="Status">
              @if ($us->aktivasi == 1)
              OK
              @else
              DISABLED
              @endif
            </td>
            @if ($us->roles_id == 3)
            {{-- Content Klik Kanan --}}
              <div id="contextMenu" class="cm_{{$us->id}}" style="display: none">
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
                  <li class="edit">
                    <a href="/aktivasi/{{$us->id}}">
                      @if($us->aktivasi == 1)
                      DISABLE
                      @else
                      ACTIVATE
                      @endif
                    </a>
                  </li>
                </ul>
              </div>
            @endif
            @if ($us->roles_id == 2)
            {{-- Content Klik Kanan --}}
              <div id="contextMenu" class="cm_{{$us->id}}" style="display: none">
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
                  <li class="edit">
                    <a href="/reset/{{$us->id}}">RESET</a>
                  </li>
                  <li class="detail">
                    <a href="#popup_d{{$us->id}}">DETAIL</a>
                  </li>
                </ul>
              </div>
            @endif
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
  @foreach ($data as $us)
    {{-- POPUP DETAIL DATA --}}
    <div id="popup_d{{$us->id}}" class="overlay">
      <div class="popup">
        <a class="close" href="#">&times;</a>
        <h2>DETAIL DATA</h2>
        <div class="content" style="text-align: center">
          <h4>Nama : {{$us->nama}}</h4>
          <h4>Email : {{$us->email}}</h4>
          @if(Hash::check('rahasia', $us->password))
          <h4>Password : <span style="background: yellow;"> rahasia </span></h4>
          @endif
        </div>
      </div>
    </div>
  @endforeach
  {{-- POPUP TAMBAH DATA --}}
  <div id="add" class="overlay">
    <div class="popup">
      <h2>Form Tambah Data</h2>
      <div class="content">
        <form id="form" action="/master_user_tambah" method="post">
          {{ csrf_field() }}
          <input type="reset" id="configreset" value="&times;" class="close" onclick="href();">
          <fieldset>
            <input placeholder="Nama User" autocomplete="off" type="text" name="nama" value="{{ old('nama') }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" autofocus>
            @error('nama')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
          </fieldset>
          <fieldset>
            <input placeholder="Email" autocomplete="off" type="email" name="email" value="{{ old('email') }}" tabindex="2" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
            @error('email')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
          </fieldset>         
          <fieldset>
            <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Simpan</button>
          </fieldset>
          <fieldset>
            <a id="cancel" href="/master_user">Cancel</a>
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
@endsection