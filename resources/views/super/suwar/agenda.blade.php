@extends('super.template')

@section('title','Data Kerusakan')

@section('head')
  <link rel="stylesheet" href="{{asset('style_admin/table.css')}}">
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
      <caption>Agenda Survey Laporan</caption>
      <thead>
        <tr>
          <th scope="col">Judul</th>
          <th scope="col">RT/RW</th>
          <th scope="col">Foto</th>
          <th scope="col">Tanggal Survey</th>
          <th scope="col">Foto Survey</th>
        </tr>
      </thead>
      @if ($count != 0)
        <tbody>
          @foreach($data as $sw)
            <tr id="{{$sw->id}}" class="table">
                <td data-label="Judul">{{ $sw->nama }}</td>
                <td data-label="RT/RW">{{ $sw->rt }}/{{ $sw->rw }}</td>
                <td data-label="Foto"><a href="/gambar/laporan/ori/{{$sw->foto1}}"><img src="/gambar/laporan/thumbnail/{{ $sw->foto1 }}" width="100px" height="auto"></a></td>
                <td data-label="Tanggal Survey">{{$sw->survey}}</td>
                <td data-label="Foto Survey">
                  <a href="/gambar/survey/ori/{{$sw->photo}}">
                    <img src="/gambar/survey/thumbnail/{{$sw->photo}}" alt=""> 
                  </a>
                </td>
                {{-- Content Klik Kanan --}}
                <div id="contextMenu" class="cm_{{$sw->id}}" style="display: none">
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="display:block;position:static;margin-bottom:5px;">
                    <li class="edit">
                        <a href="#popup_s{{$sw->id}}">EDIT</a>
                    </li>
                    <li class="detail">
                        <a href="#popup_v{{$sw->id}}">VALID</a>
                    </li>
                    </ul>
                </div>
            </tr>
          @endforeach
        </tbody>
      @else
        <tbody>
          <tr>Data masih kosong!</tr>
        </tbody>
      @endif
    </table>
    <div class="pagination">
        <a style="right: 0; width: 50px;" href="#map"><i style="width: 28px; height: 28px; color: mediumseagreen;" class="fa fa-globe fa-2x"></i></a>
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
  {{-- SURVEY --}}
  <div id="popup_s{{$sw->id}}" class="overlay">
    <div class="popup">
      <h2>Perbarui data</h2>
      <div class="content">
        <form id="form" action="/survey/{{$id}}" method="post">
          {{ csrf_field() }}
          <input type="reset" id="configreset" value="&times;" class="close" onclick="href();">
          <fieldset>
            <label for="">Tanggal Survey</label><br><br>
            <input placeholder="Tanggal Survey" type="date" autocomplete="off" name="survey" value="{{$sw->survey}}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
            <label style="font-size: 12px; color: #888;" for="survey"></label>
            @error('survey')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
          </fieldset>
          <fieldset>
            <label for="">Foto Survey</label>
            <input style="margin-top: 10px" type="file" id="fileimg1" accept="image/*" name="foto">
            <img style="margin-left: 20px" width="50px" height="auto" src="/gambar/survey/thumbnail/{{$sw->photo}}" alt="">
            @error('foto1')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror          </fieldset>
          <fieldset>
            <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Simpan</button>
          </fieldset>
      </form>
      </div>
    </div>
  </div>
  <div id="popup_v{{$sw->id}}" class="overlay">
    <div class="popup">
      <h2>MASUKKAN DATA KEDALAM KERUSAKAN?</h2>
      <div class="content">
        <fieldset class="acc">
          <a class="ya" href="/valid/{{ $sw->id }}">YA, MASUKKAN.</a>
          <a class="cancel" href="#">Batal</a>
        </fieldset>
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