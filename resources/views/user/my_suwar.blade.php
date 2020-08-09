@extends('user.lay')
@section('head')
<link rel="stylesheet" href="{{asset('style_user/my_suwar.css')}}">
<link rel="stylesheet" href="{{asset('style_admin/table.css')}}">
<link rel="stylesheet" href="{{asset('style_admin/popup.css')}}">
<link rel="stylesheet" href="{{asset('style_admin/form.css')}}">
@endsection
@section('title','Profile')

@section('isi')
@section('profile')
<a class="navoption" href="#edit">Profile</a>
@endsection
@if (session('edit'))
<div class="warning"><i class="fa fa-pencil-circle-o fa-2x" aria-hidden="true"></i>{{session('edit')}}</div>
@endif
<table>
    <caption>Laporan Saya</caption>
    <thead>
      <tr>
        <th scope="col">No</th>
        <th scope="col">Judul</th>
        <th scope="col">RT/RW</th>
        <th scope="col">Desa</th>
        <th scope="col">Foto</th>
        <th scope="col">Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach($data as $sw)
        <tr id="{{$sw->id}}" class="table">
          <td data-label="No">{{ $loop->iteration }}</td>
          <td data-label="Judul">{{ $sw->nama }}</td>
          <td data-label="RT/RW">{{ $sw->rt }}/{{ $sw->rw }}</td>
          <td data-label="Desa">{{ $sw->nama_desa }}</td>
          <td data-label="Foto"><a href="/gambar/laporan/ori/{{$sw->foto1}}"><img src="/gambar/laporan/thumbnail/{{ $sw->foto1 }}" width="100px" height="auto"></a></td>
          <td data-label="Status" style="color:white;background: @if($sw->status==1) dodgerblue @elseif($sw->status==2) forestgreen @else indianred @endif">@if($sw->status==1) Diterima @elseif($sw->status==2) Disetujui @else Ditunda @endif</td>
        </tr>
      @endforeach
    </tbody>
</table>
<div class="pagination">
    <a style="color:white; padding: 10px;" href="/suwar"><i class="fa fa-plus fa-2x"></i></a>
    <?php
      // config
      $link_limit = 10;
      ?>

      @if ($data->lastPage() > 1)
          <ul style="background: white;">
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
  {{-- POPUP PROFILE --}}
  <div id="edit" class="overlay">
    <div class="popup">
      <h2>Form Ubah Data Pengguna</h2>
      <div class="content">
        <form id="form" action="/u_display/{{Auth::user()->id}}" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <input type="reset" id="configreset" value="&times;" class="close" onclick="href();">
          <fieldset>
              <label for="">Ubah Nama</label>
              <input placeholder="Nama" type="text" autocomplete="off" name="nama" value="{{ Auth::user()->nama ?? old('nama') }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" autofocus>
              @error('nama')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror 
          </fieldset>
          <fieldset>
              <label for="">Ubah Email</label>
              <input placeholder="Email" type="text" autocomplete="off" name="email" value="{{ Auth::user()->email ?? old('email') }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" autofocus>
              @error('email')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror 
          </fieldset>
          <fieldset>
              <label for="">Ubah Foto Profile</label>
              <input type="file" id="fileimg1" accept="image/*" name="photo">
              <img style="margin-left: 20px" width="100px" height="auto" src="/gambar/user/{{Auth::user()->photo}}">
              @error('photo')
              <div class="invalid-feedback">
                  {{$message}}
              </div>
              @enderror
          </fieldset>
          <fieldset>
            <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Simpan</button>
          </fieldset>
        </form> 
        <form id="form" action="/u_password/{{Auth::user()->id}}" method="post">
          <label for="">Perbarui Password</label>
          <fieldset>
            <input placeholder="Password Baru" autocomplete="off" type="password" name="password" value="{{ old('password') }}" tabindex="2" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
            @error('password')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
            <input placeholder="Konfirmasi Password Baru" type="email" name="email" value="{{ old('email') }}" tabindex="2" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
            @error('email')
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
  <script>
    function href() {
      window.location.href = '#';
    }
  </script>
@endsection