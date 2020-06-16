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
@endsection
@section('copy')
oncopy='return false' oncut='return false' onpaste='return false'
@endsection
@section('breadcrump')
    Master Kecamatan
@endsection
@section('isi')
  <div class="isi">
    @if (session('sukses'))
      <section class="section alert-section">
        <div class="alert alert-success">
          <div class="alert-container">
            <div class="alert-icon">
              <i class="fa fa-info"></i>
            </div>
            <b class="alert-info">Sukses menyimpan:</b> Data yang Anda masukkan sukses disimpan kedalam sistem..
          </div>
        </div>
      </section>
    @endif
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
      <tbody>
        @foreach($kcmtn as $kc)
        <tr id="{{$kc->id}}" class="table">
          <td data-label="No">{{ $loop->iteration }}</td>
          <td data-label="Nama Kecamatan">{{ $kc->nama }}</td>
          <td data-label="Jumlah Desa">{{ $kc->desa }}</td>
          <td data-label="Nama Kepala Camat">{{ $kc->nama_cmt }}</td>
            {{-- Content Klik Kanan --}}
            <div id="contextMenu" class="cm_{{$kc->id}}" style="display: none">
              <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
                <li class="edit">
                  <a href="#popup_e{{$kc->id}}">Edit</a>
                </li>
                <li class="hapus">
                  {{-- <a href="/admin_desa_hapus/{{ $kc->id }}">Hapus</a> --}}
                  <a href="#">Hapus</a>
                </li>
                <li class="detail">
                  <a href="/admin_desa/{{$kc->id}}">Detail</a>
                </li>
              </ul>
            </div>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="pagination">
        <a class="add" href="#popup1">Tambah Kecamatan</a>
        <?php
          // config
          $link_limit = 7; // maximum number of links (a little bit inaccurate, but will be ok for now)
          ?>

          @if ($kcmtn->lastPage() > 1)
              <ul>
                  <li class="{{ ($kcmtn->currentPage() == 1) ? ' disabled' : '' }}">
                      <a href="{{ $kcmtn->url(1) }}">First</a>
                  </li>
                  @for ($i = 1; $i <= $kcmtn->lastPage(); $i++)
                      <?php
                      $half_total_links = floor($link_limit / 2);
                      $from = $kcmtn->currentPage() - $half_total_links;
                      $to = $kcmtn->currentPage() + $half_total_links;
                      if ($kcmtn->currentPage() < $half_total_links) {
                        $to += $half_total_links - $kcmtn->currentPage();
                      }
                      if ($kcmtn->lastPage() - $kcmtn->currentPage() < $half_total_links) {
                          $from -= $half_total_links - ($kcmtn->lastPage() - $kcmtn->currentPage()) - 1;
                      }
                      ?>
                      @if ($from < $i && $i < $to)
                          <li class="{{ ($kcmtn->currentPage() == $i) ? ' active' : '' }}">
                              <a href="{{ $kcmtn->url($i) }}">{{ $i }}</a>
                          </li>
                      @endif
                  @endfor
                  <li class="{{ ($kcmtn->currentPage() == $kcmtn->lastPage()) ? ' disabled' : '' }}">
                      <a href="{{ $kcmtn->url($kcmtn->lastPage()) }}">Last</a>
                  </li>
              </ul>
@endif
    </div>
  </div>
  @foreach ($kcmtn as $kc)
    <div id="popup_e{{$kc->id}}" class="overlay">
      <div class="popup">
        <h2>Edit Data Desa</h2>
        <a class="close" href="#">&times;</a>
        <div class="content">
          <form id="form" action="/admin_kecamatan_ubah" method="post">
            {{ csrf_field() }}
            <fieldset>
              <input placeholder="Nama Kecamatan" type="text" name="nama" value="{{ $kc->nama }}" tabindex="1" required autofocus readonly>
            </fieldset>
            <fieldset>
              <input placeholder="Jumlah Desa" type="text" name="desa" value="{{ $kc->desa }}" tabindex="2" required readonly>
            </fieldset>
            <fieldset>
              <input placeholder="Nama Camat" type="text" name="nama_cmt" value="{{ $kc->nama_cmt }}" tabindex="1" required autofocus readonly>
            </fieldset>

            <fieldset>
              <input placeholder="Nama Kecamatan Baru" type="text" name="nama" value="{{ old('nama') }}" tabindex="1" required autofocus readonly>
            </fieldset>
            <fieldset>
              <input placeholder="Jumlah Desa Baru" type="text" name="desa" value="{{ old('desa') }}" tabindex="2" required readonly>
            </fieldset>
            <fieldset>
              <input placeholder="Nama Camat Baru" type="text" name="nama_cmt" value="{{ old('nama_cmt') }}" tabindex="1" required autofocus readonly>
            </fieldset>
            <fieldset>
              <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Submit</button>
            </fieldset>
        </form>
        </div>
      </div>
    </div>
  @endforeach
  <div id="popup1" class="overlay">
    <div class="popup">
      <h2>Form Tambah Data Kecamatan</h2>
      <a class="close" href="#">&times;</a>
      <div class="content">
        <form id="form" action="/admin_kecamatan_tambah" method="post">
          {{ csrf_field() }}
          <fieldset>
            <input placeholder="Nama Kecamatan" type="text" name="nama" value="{{ old('nama') }}" tabindex="1" required autofocus>
          </fieldset>
          <fieldset>
            <input placeholder="Jumlah Desa" type="text" name="desa" value="{{ old('desa') }}" tabindex="2" required>
          </fieldset>
          <fieldset>
            <input placeholder="Nama Camat" type="text" name="nama_cmt" value="{{ old('nama_cmt') }}" tabindex="3" required>
          </fieldset>
          <fieldset>
            <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Simpan</button>
          </fieldset>
      </form>
      </div>
    </div>
  </div>
  <div id="hapus" class="overlay">
    <div class="popup">
      <h2>Hapus data ini?</h2>
      <a class="tombol ya" href="#">Ya</a>
      <a class="tombol td" href="#">Tidak</a>
    </div>
  </div>
@endsection
@section('script')
  <script>
    $(function() {
      $('#contextMenu .hapus').on('click', function() {
        $("#hapus .popup a.tombol .ya").attr("href","/admin_desa_hapus/");
      });
      $("#hapus .popup a.tombol .ya").attr("href","/admin_desa_hapus/");
    })
  </script>
    <script src="{{asset('js_admin/action.js')}}"></script>
@endsection