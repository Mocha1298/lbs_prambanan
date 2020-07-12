<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://use.fontawesome.com/46ea1af652.js"></script>
    <link rel="stylesheet" href="{{asset('style_admin/style.css')}}">
    <link rel="stylesheet" href="{{asset('style_admin/dropdown-user.css')}}">
    <link rel="stylesheet" href="{{asset('style_admin/notif.css')}}">
    <link rel="stylesheet" href="{{asset('style_admin/popup.css')}}">
    <script src="{{asset('jquery/jquery.js')}}"></script>
    <script src="{{asset('js_admin/nav.js')}}"></script>
    @yield('head')
</head>
<body @yield('copy') >
    <div class="alert alert-warning alert-dismissible fade show">
      POSISI MARKER DIUBAH
    </div>
    <div class="container">
        <header>
            <h2 class="bagian header">
              <div class="notif" onclick="stop();">
                <a href="#notif">
                  <i class="fa fa-bell-o"></i>
                </a>
              </div>
              <span class="log">
                <label for="profile2" class="profile-dropdown">
                    <input type="checkbox" id="profile2">
                    <img src="https://cdn0.iconfinder.com/data/icons/avatars-3/512/avatar_hipster_guy-512.png">
                    <span>{{auth()->user()->nama}}</span>
                    <label for="profile2"><i class="mdi mdi-menu"></i></label>
                    <ul>
                      <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                         @csrf
                     </form></li>
                    </ul>
                  </label>
                </span>
            </h2>
        </header>
        <div class="background"></div>
        <nav>
          <ul>
            <li><a class="bagian dashboard" href="/admin"><span class='fa fa-home'></span>Dashboard</a></li>
            @if (Auth::user()->roles_id == 1)
            {{-- OLAH MASTER --}}
            <li class="topmenu">
                <div id="opener1">
                  <a href="#1" id="1" class="bagian pages" onclick="return show(1);">
                    <span class='fa fa-bookmark'></span>Olah Master
                  </a>
                </div>
                <ul class="submenu">
                  <div id="submenu1" style="display:none;">
                    <li>
                      <a class="bagian pages" href="/master_kecamatan"><span class='fa fa-bookmark'></span>Kecamatan</a>
                    </li>
                    <li>
                      <a class="bagian pages" href="/master_jenis"><span class='fa fa-bookmark'></span>Jenis Objek</a>
                    </li>
                    <li>
                      <a class="bagian pages" href="/master_user"><span class='fa fa-bookmark'></span>User</a>
                    </li>
                  </div> 
                </ul>
            </li>
            @endif
            {{-- OLAH OBJEK --}}
            <li class="topmenu">
              <div id="opener2">
                <a href="#2" id="2" class="bagian navigation" name="2" onclick="return show(2);">
                  <span class='fa fa-share'></span>Olah Objek
                </a>
              </div>
              <ul class="submenu">
                <div id="submenu2" style="display:none;">
                  @if (Auth::user()->roles_id == 1)
                  <li>
                    <a class="bagian navigation" href="/objek_peta"><span class='fa fa-share'></span>Objek Peta</a>
                  </li>
                  @else
                  <li>
                    <a class="bagian navigation" href="/objek_kerusakan/{{Auth::user()->villages_id}}"><span class='fa fa-share'></span>Kerusakan</a>
                  </li>
                  @endif
                </div> 
              </ul>
            </li>
            @if (Auth::user()->roles_id == 2)
              {{-- OLAH WARGA --}}
              <li class="topmenu">
                <div id="opener3">
                  <a href="#3" id="3" class="bagian users" name="3" onclick="return show(3);">
                    <span class='fa fa-user'></span>Suara Warga
                  </a>
                </div>
                <ul class="submenu">
                    <div id="submenu3" style="display:none;">
                      <li>
                      <a class="bagian users" href="/suwar_admin/{{Auth::user()->villages_id}}"><span class='fa fa-user'></span>Laporan</a>
                      </li>
                      <li>
                        <a class="bagian users" href="/agenda/{{Auth::user()->villages_id}}"><span class='fa fa-user'></span>Agenda</a>
                      </li>
                    </div> 
                </ul>
              </li>
            @endif
          </ul>
        </nav>
        <div class="content">
          <div class="main">
            <div class="breadcrump">
                <p>@yield('breadcrump')</p>
            </div>
            <hr>
            @if (session('simpan'))
            <div class="success"><i class="fa fa-check-circle-o fa-2x" aria-hidden="true"></i>{{session('simpan')}}</div>
            @elseif (session('edit'))
            <div class="success"><i class="fa fa-pencil-circle-o fa-2x" aria-hidden="true"></i>{{session('edit')}}</div>
            @elseif (session('hapus'))
            <div class="success"><i class="fa fa-trash fa-2x" aria-hidden="true"></i>{{session('hapus')}}</div>
            @elseif (session('gagal'))
            <div class="success"><i class="fa fa-times-circle-o fa-2x" aria-hidden="true"></i>{{session('gagal')}}</div>
            @endif
            {{-- Content --}}
            @yield('isi')
          </div>
        </div>
    </div>
      {{-- POPUP TAMBAH DATA --}}
  <div id="notif" class="overlay">
    <div class="popup">
      <h2 style="text-align: center">NOTIFIKASI SISTEM</h2>
      <a href="#" class="close">&times;</a>
      <div class="content">
        
      </div>
    </div>
  </div>
    @yield('script')
    <script>
      function stop() {
        $(".notif").css('animation','none');
      }
    </script>
</body>
</html>