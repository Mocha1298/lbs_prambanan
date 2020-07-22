<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('style_user/my_suwar.css')}}">
    <link rel="stylesheet" href="{{asset('style_admin/table.css')}}">
    <link rel="stylesheet" href="{{asset('style_admin/popup.css')}}">
    <link rel="stylesheet" href="{{asset('style_admin/form.css')}}">
    <script src="https://use.fontawesome.com/46ea1af652.js"></script>
    <script src="{{asset('jquery/jquery.js')}}"></script>
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC|Raleway" rel="stylesheet">
    <title>Laporan Anda</title>
</head>
<body>
    <header class="topnav" id="myTopnav">
        <a href="/" style="
        font-family: 'Amatic SC', sans-serif;
        color: whitesmoke;
        text-decoration: none;
        font-size: 35px;
        ">Peta-Jalan</a>
        <div class="navlist" id="navlist">
            <a class="cursor0" href="#home">&nbsp</a>
            <a class="navoption" href="/">Home</a>
            <a class="navoption" href="#edit">Profile</a>
            <a class="navoption" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
            <a href="javascript:void(0);" class="icon" id="hamburger">
                <i class="fa fa-bars"></i>
            </a>
        </div>
    </header>

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
        @if ($count != 0)
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
        @else
          <tbody>
            <tr>Data masih kosong! tambah sekarang...</tr>
          </tbody>
        @endif
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
            <form id="form" action="/ubah_display/{{Auth::user()->id}}" method="post">
              {{ csrf_field() }}
              <input type="reset" id="configreset" value="&times;" class="close" onclick="href();">
              <label for="">Nama dan Email</label>
              <fieldset>
              <input placeholder="Nama User" autocomplete="off" type="text" name="nama" value="{{ Auth::user()->nama ?? old('nama') }}" tabindex="1" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')" autofocus>
              @error('nama')
              <div class="invalid-feedback">
                  {{$message}}
                </div>
                @enderror
                <input placeholder="Email" autocomplete="off" type="email" name="email" value="{{ Auth::user()->email ?? old('email') }}" tabindex="2" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
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
            <form id="form" action="/ubah_password/{{Auth::user()->id}}" method="post">
              <label for="">Perbarui Password</label>
              <fieldset>
                <input placeholder="Password Baru" type="password" name="password" value="{{ old('password') }}" tabindex="2" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
                @error('password')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
                <input placeholder="Konfirmasi Password Baru" autocomplete="off" type="email" name="email" value="{{ old('email') }}" tabindex="2" required oninvalid="this.setCustomValidity('Data tidak boleh kosong')" oninput="setCustomValidity('')">
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
        $( document ).ready(function() {

        var opcionesnav = $('.navoption').length;
        var clickhamb=0;

        $("#hamburger").click(function(){
            clickhamb = 1;
            var header = $("#myTopnav");
            if (header[0].classList.length == 1) {
                header.addClass ("responsive");
                $("header").height((opcionesnav+1)*48);
                $(".navlist a:not(.icon)").css("display", "block");
                setTimeout(
                    function()
                    {
                        $(".navlist a:not(.icon)").css("transform", "translateX(0px)");
                    }, 50);

            } else {
                $(".navlist a:not(.icon)").css("transform", "translateX(600px)");
                header.height(48);
                setTimeout(
                    function()
                    {
                        header.removeClass("responsive");
                        header.height(48);
                        $(".navlist a:not(.icon)").css("display", "none");
                    }, 1600);
            }
        });


        $(window).on('resize', function(){
            if (($(window).width() > 600) && (clickhamb==1)){
                console.log(clickhamb + "     " + $(window).width());
                $("#myTopnav").height(48);
                $(".navlist a:not(.icon)").css("display", "block");
                setTimeout(
                    function()
                    {
                        $(".navlist a:not(.icon)").css("transform", "translateX(0px)");
                    }, 500);
            }
        });

        });
    </script>
    <script>
      function href() {
        window.location.href = '#';
      }
    </script>
</body>
</html>