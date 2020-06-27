<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('/style_user/style.css')}}">
    <link rel="stylesheet" href="{{asset('/style_user/sidebar.css')}}">
    <link rel="stylesheet" href="{{asset('/style_admin/popup.css')}}">
    <link rel="stylesheet" href="{{asset('/style_admin/form.css')}}">
    {{-- Link Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
    integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
    crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    {{-- Link LRM https://www.liedman.net/leaflet-routing-machine/ --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>

    <title>Document</title>
</head>
<body>
    <div id="mapid"></div>
    <nav role="navigation">
        <div id="menuToggle">
            <input type="checkbox"/>
            <span></span>
            <span></span>
            <span></span>
            <ul id="menu">
                <a href="/">
                    <li class="between">
                        <img style="width: 40px; height: 40px; margin-top: 10px; margin-left: 10px" src="/gambar/marker/logo.png">
                        <p >PetaJalan Prambanan</p>
                    </li>
                </a>
                <a href="#rute"><li class="between">
                    <i class="fa fa-location-arrow"></i>
                    <p>Rute</p>
                </li></a>
                @if (Auth::check())
                    <a href="/suwar"><li class="between">
                        <i class="fa fa-bullhorn"></i>
                        <p>Suara Warga</p>
                    </li></a>
                @endif
                <a href="#"><li class="between">
                    <i class="fa fa-info"></i>
                    <p>Pusat Informasi</p>
                </li></a>
                @if (Auth::check())
                    <a href="/logout"><li class="between">
                        <i class="fa fa-power-off"></i>
                        <p>Logout</p>
                    </li></a>
                @else
                    <a href="/login"><li class="between">
                        <i class="fa fa-power-off"></i>
                        <p>Login</p>
                    </li></a>
                @endif
            </ul>
        </div>
    </nav>
    <script src="{{asset('js_admin/bundle.js')}}"></script>
    <script src="{{asset('js_admin/polygon.js')}}"></script>
    <script src="{{asset('js_admin/show_map.js')}}"></script>
</body>
</html>