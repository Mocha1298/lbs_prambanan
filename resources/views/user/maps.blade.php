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

    <title>Peta-Jalan</title>
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
                        <img style="width: 40px; height: 40px; margin: 10px 23px 0 11px" src="/gambar/marker/logo.png">
                        <p>Home</p>
                    </li>
                </a>
            </ul>
        </div>
    </nav>
    <script src="{{asset('js_admin/bundle.js')}}"></script>
    <script src="{{asset('js_admin/polygon.js')}}"></script>
    <script src="{{asset('js_admin/show_map.js')}}"></script>
</body>
</html>