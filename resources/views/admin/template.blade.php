<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://use.fontawesome.com/f5184190ae.js"></script>
    <link rel="stylesheet" href="{{asset('style_admin/style.css')}}">
    <script src="{{asset('js_admin/nav.js')}}"></script>
    @yield('head')
</head>
<body @yield('copy') >
    <div class="container">
        <header>
            <h2 class="bagian header">
                <span class="log">
                    <a href="#">Logout</a>
                </span>Olah Master
            </h2>
        </header>

        <nav>
          <ul>
            <li><a class="bagian dashboard" href="/"><span class='fa fa-home'></span>Dashboard</a></li>
            {{-- OLAH MASTER --}}
            <li class="topmenu">
                <div id="opener">
                  <a href="#1" id="1" class="bagian pages" onclick="return show(1);">
                    <span class='fa fa-bookmark'></span>Olah Master
                  </a>
                </div>
                  <ul class="submenu">
                    <div id="submenu1" style="display:none;">
                      <li>
                        <a class="bagian pages" href="/admin_kecamatan"><span class='fa fa-bookmark'></span>Kecamatan</a>
                      </li>
                      <li>
                        <a class="bagian pages" href="/admin_desa"><span class='fa fa-bookmark'></span>Desa</a>
                      </li>
                      <li>
                        <a class="bagian pages" href="/admin_jenis"><span class='fa fa-bookmark'></span>Jenis Objek</a>
                      </li>
                      <li>
                        <a class="bagian pages" href="/admin_user"><span class='fa fa-bookmark'></span>User</a>
                      </li>
                      <div id="upbutton"><a onclick="return hide(1);"><i class="fa fa-chevron-up"></i></a></div>
                    </div> 
                  </ul>
            </li>
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
                      <a class="bagian navigation" href="/admin_objek"><span class='fa fa-share'></span>Objek Peta</a>
                    </li>
                    <li>
                      <a class="bagian navigation" href="/admin_kerusakan"><span class='fa fa-share'></span>Kerusakan</a>
                    </li>
                    <li>
                      <a class="bagian navigation" href="/admin_peta"><span class='fa fa-share'></span>Peta</a>
                    </li>
                    <div id="upbutton"><a onclick="return hide(2);"><i class="fa fa-chevron-up"></i></a></div>
                  </div> 
                </ul>
            </li>
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
                      <a class="bagian users" href="/admin_lapor1"><span class='fa fa-user'></span>Objek Peta</a>
                    </li>
                    <li>
                      <a class="bagian users" href="/admin_lapor2"><span class='fa fa-user'></span>Kerusakan</a>
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
            {{-- Content --}}
            @yield('isi')
          </div>
        </div>
        
        <footer class="bagian">
              <p class="copy">&copy; Prambanan</p>
        </footer>
    </div>
    @yield('script')
</body>
</html>