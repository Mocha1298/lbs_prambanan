@extends('super.template')

@section('title','Master Desa')

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
    Master Desa
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
      <caption>Tabel Desa</caption>
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Nama Desa</th>
          <th scope="col">Jumlah RW</th>
        </tr>
      </thead>
      <tbody>
        @foreach($desa as $ds)
        <tr id="{{$ds->id}}" class="table">
          <td data-label="No">{{ $loop->iteration }}</td>
          <td data-label="Nama Desa">{{ $ds->nama }}</td>
          <td data-label="Jumlah RW">{{ $ds->rw }}</td>
            {{-- Content Klik Kanan --}}
            <div id="contextMenu" class="cm_{{$ds->id}}" style="display: none">
              <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
                <li class="edit">
                  <a href="#popup_e{{$ds->id}}">Edit</a>
                </li>
                <li class="hapus">
                  {{-- <a href="/admin_desa_hapus/{{ $ds->id }}">Hapus</a> --}}
                  <a href="#">Hapus</a>
                </li>
              </ul>
            </div>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="pagination">
        <a class="add" href="#popup1">Tambah Desa</a>
        <?php
          // config
          $link_limit = 7; // maximum number of links (a little bit inaccurate, but will be ok for now)
          ?>

          @if ($desa->lastPage() > 1)
              <ul>
                  <li class="{{ ($desa->currentPage() == 1) ? ' disabled' : '' }}">
                      <a href="{{ $desa->url(1) }}">First</a>
                  </li>
                  @for ($i = 1; $i <= $desa->lastPage(); $i++)
                      <?php
                      $half_total_links = floor($link_limit / 2);
                      $from = $desa->currentPage() - $half_total_links;
                      $to = $desa->currentPage() + $half_total_links;
                      if ($desa->currentPage() < $half_total_links) {
                        $to += $half_total_links - $desa->currentPage();
                      }
                      if ($desa->lastPage() - $desa->currentPage() < $half_total_links) {
                          $from -= $half_total_links - ($desa->lastPage() - $desa->currentPage()) - 1;
                      }
                      ?>
                      @if ($from < $i && $i < $to)
                          <li class="{{ ($desa->currentPage() == $i) ? ' active' : '' }}">
                              <a href="{{ $desa->url($i) }}">{{ $i }}</a>
                          </li>
                      @endif
                  @endfor
                  <li class="{{ ($desa->currentPage() == $desa->lastPage()) ? ' disabled' : '' }}">
                      <a href="{{ $desa->url($desa->lastPage()) }}">Last</a>
                  </li>
              </ul>
@endif
    </div>
  </div>
  @foreach ($desa as $ds)
    <div id="popup_e{{$ds->id}}" class="overlay">
      <div class="popup">
        <h2>Edit Data Desa</h2>
        <a class="close" href="#">&times;</a>
        <div class="content">
          <form id="form" action="/admin_desa_tambah" method="post">
            {{ csrf_field() }}
            <fieldset>
              <input placeholder="Nama Desa" type="text" name="nama" value="{{ $ds->nama }}" tabindex="1" required autofocus readonly>
            </fieldset>
            <fieldset>
              <input placeholder="Jumlah RW" type="text" name="rw" value="{{ $ds->rw }}" tabindex="2" required readonly>
            </fieldset>
            <fieldset>
              <input placeholder="Nama Desa Baru" type="text" name="nama" value="{{ old('nama') }}" tabindex="1" required autofocus>
            </fieldset>
            <fieldset>
              <input placeholder="Jumlah RW Baru" type="text" name="rw" value="{{ old('rw') }}" tabindex="2" required>
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
      <h2>Form Tambah Data Desa</h2>
      <a class="close" href="#">&times;</a>
      <div class="content">
        <form id="form" action="/admin_desa_tambah" method="post">
          {{ csrf_field() }}
          <fieldset>
            <input placeholder="Nama Desa" type="text" name="nama" value="{{ old('nama') }}" tabindex="1" required autofocus>
          </fieldset>
          <fieldset>
            <input placeholder="Jumlah RW" type="text" name="rw" value="{{ old('rw') }}" tabindex="2" required>
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