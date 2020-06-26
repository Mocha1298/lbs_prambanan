<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://use.fontawesome.com/f5184190ae.js"></script>
    <link rel="stylesheet" href="{{asset('style_admin/style.css')}}">
    <link rel="stylesheet" href="{{asset('style_admin/dropdown-user.css')}}">
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
                <span class="log">
                  <label for="profile2" class="profile-dropdown">
                    <input type="checkbox" id="profile2">
                    <img src="https://cdn0.iconfinder.com/data/icons/avatars-3/512/avatar_hipster_guy-512.png">
                    <span>{{auth()->user()->nama}}</span>
                    <label for="profile2"><i class="mdi mdi-menu"></i></label>
                    <ul>
                      <li><a href="#"><i class="mdi mdi-email-outline"></i>Messages</a></li>
                      <li><a href="#"><i class="mdi mdi-account"></i>Account</a></li>
                      <li><a href="#"><i class="mdi mdi-settings"></i>Settings</a></li>
                      <li><a href="/logout"><i class="mdi mdi-logout"></i>Logout</a></li>
                    </ul>
                  </label>
                </span>Olah Master
            </h2>
        </header>






<!-- Template layout -->

<div class="background"></div>

        <nav>
          <ul>
            <li><a class="bagian dashboard" href="/super"><span class='fa fa-home'></span>Dashboard</a></li>
            {{-- OLAH MASTER --}}
            <li class="topmenu">
                <div id="opener">
                  <a href="#1" id="1" class="bagian pages" onclick="return show(1);">
                    <span class='fa fa-bookmark'></span>Olah Master
                  </a>
                </div>
                  <ul class="submenu">
                    <div id="submenu1" style="display:none;">
                      @if (Auth::user()->roles_id == 1)
                      <li>
                        <a class="bagian pages" href="/master_kecamatan"><span class='fa fa-bookmark'></span>Kecamatan</a>
                      </li>
                      <li>
                        <a class="bagian pages" href="/master_jenis"><span class='fa fa-bookmark'></span>Jenis Objek</a>
                      </li>
                      <li>
                        <a class="bagian pages" href="/master_user"><span class='fa fa-bookmark'></span>User</a>
                      </li>
                      @else
                      <li>
                        <a class="bagian pages" href="/objek_kerusakan/{{Auth::user()->villages_id}}"><span class='fa fa-bookmark'></span>Kerusakan</a>
                      </li>
                      @endif
                      <div id="upbutton"><a onclick="return hide(1);"><i class="fa fa-chevron-up"></i></a></div>
                    </div> 
                  </ul>
            </li>
            @if (Auth::user()->roles_id == 1)
                {{-- OLAH OBJEK --}}
                <li class="topmenu">
                  <div id="opener">
                    <a href="#2" class="bagian navigation" name="2" onclick="return show(2);">
                      <span class='fa fa-share'></span>Olah Objek
                    </a>
                  </div>
                    <ul class="submenu">
                      <div id="submenu2" style="display:none;">
                        <li>
                          <a class="bagian navigation" href="/objek_peta"><span class='fa fa-share'></span>Objek Peta</a>
                        </li>
                        <li>
                          <a class="bagian navigation" href="/objek_kerusakan"><span class='fa fa-share'></span>Objek Kerusakan</a>
                        </li>
                        <div id="upbutton"><a onclick="return hide(2);"><i class="fa fa-chevron-up"></i></a></div>
                      </div> 
                    </ul>
                </li>
            @endif
            {{-- OLAH WARGA --}}
            <li class="topmenu">
              <div id="opener">
                <a href="#3" class="bagian users" name="3" onclick="return show(3);">
                  <span class='fa fa-user'></span>Suara Warga
                </a>
              </div>
                <ul class="submenu">
                  <div id="submenu3" style="display:none;">
                    <li>
                      <a class="bagian users" href="/lapor_lapor1"><span class='fa fa-user'></span>Laporan</a>
                    </li>
                    <li>
                      <a class="bagian users" href="/lapor_lapor2"><span class='fa fa-user'></span>Agenda</a>
                    </li>
                    <div id="upbutton"><a onclick="return hide(3);"><i class="fa fa-chevron-up"></i></a></div>
                  </div> 
                </ul>
            </li>
          </ul>
        </nav>
        
        <div class="content">
          <div class="main">
            <div class="breadcrump">
                <p>@yield('breadcrump')</p>
            </div>
            <hr>
            @if (session('simpan'))
            <div class="success">{{session('simpan')}}</div>
            @elseif (session('edit'))
            <div class="info">{{session('edit')}}</div>
            @elseif (session('hapus'))
            <div class="warning">{{session('hapus')}}</div>
            @elseif (session('gagal'))
            <div class="error">{{session('gagal')}}</div>
            @endif
            {{-- Content --}}
            @yield('isi')
          </div>
        </div>
        
    </div>
    @yield('script')
</body>
</html>