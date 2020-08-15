<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{asset('/gambar/logo/logo.png')}}">
    <title>@yield('title')</title>
    <script src="https://use.fontawesome.com/46ea1af652.js"></script>
    <link rel="stylesheet" href="{{asset('style_admin/style.css')}}">
    <link rel="stylesheet" href="{{asset('style_admin/dropdown-user.css')}}">
    <link rel="stylesheet" href="{{asset('style_admin/popup.css')}}">
    <link rel="stylesheet" href="{{asset('style_admin/notifikasi.css')}}">
    <script src="{{asset('jquery/jquery.js')}}"></script>
    <script src="https://js.pusher.com/6.0/pusher.min.js"></script>
    <script src="{{asset('js_admin/nav.js')}}"></script>
    @yield('head')
</head>
<body @yield('copy') >
    <div class="container">
        <header>
            <h2 class="bagian header">
              <div class="notif" onclick="stop();">
                @if(Auth::user()->roles_id == 2)
                  <a href="/suwar_admin/{{Auth::user()->villages_id}}">
                    <div id="notification" class="notification" data-count="0"></div>
                  </a>
                @endif
              </div>
              <span class="log">
                <label for="profile2" class="profile-dropdown">
                    <input type="checkbox" id="profile2">
                    <img src="/gambar/user/{{Auth::user()->photo}}">
                    <span>{{auth()->user()->nama}}</span>
                    <label for="profile2"><i class="mdi mdi-menu"></i></label>
                    <ul>
                      <li><a class="dropdown-item" href="/">Home</a></li>
                      <li><a class="dropdown-item" href="/profile/{{Auth::user()->id}}">Profile</a></li>
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
            <li><a class="bagian dashboard" href="/admin"><span class='fa fa-dashboard'></span>Dashboard</a></li>
            @if (Auth::user()->roles_id == 1)
            {{-- OLAH MASTER --}}
            <li class="topmenu">
                <div id="opener1">
                  <a href="#1" id="1" class="bagian pages" onclick="return show(1);">
                    <span class='fa fa-folder'></span>Olah Master
                  </a>
                </div>
                <ul class="submenu">
                  <div id="submenu1" style="display:none;">
                    <li>
                      <a class="bagian pages" href="/master_kecamatan"><span class='fa fa-home'></span>Kecamatan</a>
                    </li>
                    <li>
                      <a class="bagian pages" href="/master_jenis"><span class='fa fa-info'></span>Jenis Objek</a>
                    </li>
                    <li>
                      <a class="bagian pages" href="/master_user"><span class='fa fa-user'></span>User</a>
                    </li>
                  </div> 
                </ul>
            </li>
            @endif
            {{-- OLAH OBJEK --}}
            <li class="topmenu">
              <div id="opener2">
                <a href="#2" id="2" class="bagian navigation" name="2" onclick="return show(2);">
                  <span class='fa fa-map-marker'></span>Olah Objek
                </a>
              </div>
              <ul class="submenu">
                <div id="submenu2" style="display:none;">
                  @if (Auth::user()->roles_id == 1)
                  <li>
                    <a class="bagian navigation" href="/objek_peta"><span class='fa fa-map-pin'></span>Objek Peta</a>
                  </li>
                  @else
                  <li>
                    <a class="bagian navigation" href="/objek_kerusakan/{{Auth::user()->villages_id}}"><span class='fa fa-road'></span>Kerusakan</a>
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
                    <span class='fa fa-flag-checkered'></span>Suara Warga
                  </a>
                </div>
                <ul class="submenu">
                    <div id="submenu3" style="display:none;">
                      <li>
                      <a class="bagian users" href="/suwar_admin/{{Auth::user()->villages_id}}"><span class='fa fa-bullhorn'></span>Laporan</a>
                      </li>
                      <li>
                        <a class="bagian users" href="/agenda/{{Auth::user()->villages_id}}"><span class='fa fa-flag-checkered'></span>Agenda</a>
                      </li>
                    </div> 
                </ul>
              </li>
            @endif
            @if (Auth::user()->roles_id == 1)
              {{-- OLAH WARGA --}}
              <li class="topmenu">
                <div id="opener3">
                  <a href="/report" id="4" class="bagian users" name="4" onclick="return show(4);">
                    <span class='fa fa-flag-checkered'></span>Laporan
                  </a>
                </div>
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
            <div class="warning"><i class="fa fa-pencil-circle-o fa-2x" aria-hidden="true"></i>{{session('edit')}}</div>
            @elseif (session('hapus'))
            <div class="error"><i class="fa fa-trash fa-2x" aria-hidden="true"></i>{{session('hapus')}}</div>
            @elseif (session('gagal'))
            <div class="error"><i class="fa fa-times-circle-o fa-2x" aria-hidden="true"></i>{{session('gagal')}}</div>
            @endif
            {{-- Content --}}
            @yield('isi')
          </div>
        </div>
    </div>
      {{-- POPUP TAMBAH DATA --}}
  <div id="notif" class="overlay">
    <div class="popup">
      <h2 style="text-align: center">NOTIFIKASI</h2>
      <a href="#" class="close">&times;</a>
      <div class="content">
        
      </div>
    </div>
  </div>
    @yield('script')
  @if (Auth::user()->roles_id != 1)
    <script>
      var id = {{Auth::user()->id}};
      var bell = document.getElementById('notification');
      // Enable pusher logging - don't include this in production
      Pusher.logToConsole = false;

      var pusher = new Pusher('c70441997e3d2b65ebed', {
        cluster: 'ap1',
        forceTLS: true
      });

      var count = 0

      var channel = pusher.subscribe('my-channel');
      channel.bind('App\\Events\\sendName', function(data) {
        if(id == data.id){
          count = Number(bell.attributes[2].nodeValue);
          bell.setAttribute('data-count', count + 1);
          console.log(bell.attributes[2].nodeValue);
          bell.classList.add('show-count');
          bell.classList.add('notify');
          alert('Ada Laporan Masuk. Silahkan Cek Laporan.');
        }
      });
      bell.addEventListener("animationend", function(event){
        bell.classList.remove('notify');
      });
    </script>
  @endif
</body>
</html>