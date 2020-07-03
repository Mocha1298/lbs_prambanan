@extends('super.template')

@section('title','Master User')

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
    Master User
@endsection
@section('isi')
  <div class="isi">
    <table>
      <caption>Tabel User</caption>
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Nama User</th>
          <th scope="col">Email</th>
          <th scope="col">Status</th>
        </tr>
      </thead>
      @if ($count != 0)
        <tbody>
          @foreach($data as $us)
          <tr id="{{$us->id}}" class="table">
            <td data-label="No">{{ $loop->iteration }}</td>
            <td data-label="Nama User">{{ $us->nama }}</td>
            <td data-label="Email">{{ $us->email }}</td>
            <td data-label="Status">
              @if ($us->aktivasi == 0)
              UNCOFIRMED
              @elseif ($us->aktivasi == 1)
              OK
              @else
              DISABLED
              @endif
            </td>
              {{-- Content Klik Kanan --}}
              <div id="contextMenu" class="cm_{{$us->id}}" style="display: none">
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
                  <li class="edit">
                    <a href="#popup_e{{$us->id}}">EDIT</a>
                  </li>
                  <li class="hapus">
                    <a href="#popup_h{{$us->id}}">HAPUS</a>
                  </li>
                  <li class="detail">
                    <a href="/master_desa/{{$us->id}}">DISABLE</a>
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
        <a style="color:white;" class="add" href="#add">Tambah Admin</a>
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
  @foreach ($data as $us)
    {{-- POPUP EDIT DATA --}}
    <div id="popup_e{{$us->id}}" class="overlay">
      <div class="popup">
        <h2>Edit Data User</h2>
        <a class="close" href="/master_user">&times;</a>
        <div class="content">
        <form id="form" action="/master_user_ubah/{{$us->id}}" method="post">
            {{ csrf_field() }}
            <fieldset>
              <input placeholder="Nama User" type="text" name="nama" value="{{ old('nama') ?? $us->nama }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" autofocus>
              @error('nama')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <fieldset>
              <input placeholder="Jumlah Desa" type="text" name="desa" value="{{ old('desa') ?? $us->desa }}" tabindex="2" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
              @error('desa')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>
            <fieldset>
              <input placeholder="Nama Camat" type="text" name="nama_cmt" value="{{ old('nama_cmt') ?? $us->nama_cmt }}" tabindex="1"  oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
              @error('nama_cmt')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
            </fieldset>

            <fieldset>
              <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Submit</button>
            </fieldset>
        </form>
        </div>
      </div>
    </div>
    {{-- POPUP HAPUS DATA --}}
    <div id="popup_h{{$us->id}}" class="overlay">
      <div class="popup">
        <h2>Hapus Data Kecataman?</h2>
        <div class="content">
          <fieldset class="acc">
            <a class="acc" href="/master_User_hapus/{{ $us->id }}">HAPUS</a>
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
        <form id="form" action="/master_user_tambah" method="post">
          {{ csrf_field() }}
          <fieldset>
            <input placeholder="Nama User" autocomplete="off" type="text" name="nama" value="{{ old('nama') }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" autofocus>
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