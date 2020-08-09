<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{asset('/gambar/logo/logo.png')}}">
    <link rel="stylesheet" href="{{asset('/style_admin/popup.css')}}">
    <link rel="stylesheet" href="{{asset('/style_user/style.css')}}">
    <link rel="stylesheet" href="{{asset('/style_user/sidebar.css')}}">
    <link rel="stylesheet" href="{{asset('/style_user/box-map.css')}}">
    <link rel="stylesheet" href="{{asset('/style_user/filter.css')}}">
    <script src="{{asset('jquery/jquery.js')}}"></script>
    <script src="https://js.pusher.com/6.0/pusher.min.js"></script>
    <script src="https://use.fontawesome.com/46ea1af652.js"></script>
    {{-- LEAFLET --}}
    <link rel="stylesheet" href="{{asset('/css/leaflet-routing-machine.css')}}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />
    <title>PETA KERUSAKAN</title>
</head>
<body>
    <div id="mapid"></div>
    <style>
        img.icon_current{
            border-radius: 50%;
            border: 3px solid white;
        }
        .leaflet-routing-container.leaflet-bar.leaflet-control{
            margin-top: 60vh;
        }
        .leaflet-control-container .leaflet-routing-container-hide {
            display: none;
        }
        .leaflet-routing-container.leaflet-bar.leaflet-control{
            bottom: 20px;
            margin-left: 10px;
        }
        @media all and (max-width: 800px){
            .leaflet-routing-container.leaflet-bar.leaflet-control{
            margin-top: 60vh;
        }
        }
    </style>
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
                @if(Auth::check())
                    @if(Auth::user()->roles_id == 3)
                    <a href="/my_suwar/{{Auth::user()->id}}">
                        <li class="between">
                            <i class="fa fa-user"></i>
                            <p>Profile</p>
                        </li>
                    </a>
                    @else
                    <a href="/admin">
                        <li class="between">
                            <i class="fa fa-cog"></i>
                            <p>Admin</p>
                        </li>
                    </a>
                    @endif
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <li class="between">
                            <i class="fa fa-sign-out"></i>
                            <p>logout</p>
                        </li>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                <a href="/login">
                    <li class="between">
                        <i class="fa fa-sign-out"></i>
                        <p>Login</p>
                    </li>
                </a>
                @endif
            </ul>
        </div>
    </nav>
    <div class="panel">
        <div class="body">
            <div class="content">
                <button onclick="hide(0);" id="show">OBJEK <i class="fa fa-eye-slash"></i></button>
                <select name="desa" id="desa">
                    <option value="">DESA</option>
                    @foreach ($desa as $ds)
                        <option value="{{$ds->id}}">{{$ds->nama}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <a class="tarikan" onclick="tarik(0);"><i class="fa fa-caret-down fa-2x"></i></a>
    </div>
    <img src="/logo/routing.gif" onclick="return icon();" alt="" class="routing">
    <div class="detail"></div>
    <div class="location">
        <button class="loc" onclick="return locateUser();"><img src="/gambar/logo/locate.png" alt=""></button>
    </div>
    <script>
        function tarik(x) {
            if(x == 0){
                $('.panel').css('top','0');
                $('.panel .tarikan')[0].attributes.onclick.nodeValue = "tarik(1);";
                $('.panel .tarikan')[0].innerHTML = "<i class='fa fa-caret-up fa-2x'></i>";
            }
            else{
                $('.panel').css('top','-100px');
                $('.panel .tarikan')[0].attributes.onclick.nodeValue = "tarik(0);";
                $('.panel .tarikan')[0].innerHTML = "<i class='fa fa-caret-down fa-2x'></i>";
            }
        }
    </script>
    <script>
        function show(id) {
            var x = database(id);
            $('.detail')[0].innerHTML = x;
            window.location.href = "#popup"+id+"";
        }
        function database(id) {
            var data = {!! json_encode($data->toArray(), JSON_HEX_TAG) !!};
            for (var i = 1; i <= data.length; i++) {
                var con = data[i].id;
                if (con == id) {
                    return output(data[i].id,data[i].kerusakan,data[i].level,data[i].status,data[i].foto1,data[i].foto2,data[i].foto3);
                }
            }
        }
        function output(id,nama,level,status,foto1,foto2,foto3) {
            var foto;
            if (status == 'Rencana') {
                return "<div id='popup"+id+"' class='overlay'><div class='popup'><h2>Detail Info</h2><a href='#' class='close'>&times;</a><div style='text-align: center' class='content'><h4>Nama Kerusakan : "+nama+"</h4><h4>Level Kerusakan : "+level+"</h4><h4>Status Kerusakan :  Perbaikan</h4><h4>Tanggal Perbaikan : </h4><h4>Foto :</h4><a href='/gambar/kerusakan/ori/"+foto1+"'><img src='/gambar/kerusakan/thumbnail/"+foto1+"' alt=''></a></div></div></div>";
            }
            if(status == 'Sedang'){
                return "<div id='popup"+id+"' class='overlay'><div class='popup'><h2>Detail Info</h2><a href='#' class='close'>&times;</a><div style='text-align: center' class='content'><h4>Nama Kerusakan : "+nama+"</h4><h4>Level Kerusakan : "+level+"</h4><h4>Status Kerusakan :  Perbaikan</h4><h4>Tanggal Perbaikan : </h4><h4>Foto :</h4><a href='/gambar/kerusakan/ori/"+foto1+"'><img src='/gambar/kerusakan/thumbnail/"+foto1+"' alt=''></a><a href='/gambar/kerusakan/ori/"+foto2+"'><img src='/gambar/kerusakan/thumbnail/"+foto2+"' alt=''></a></div></div></div>";
            }
            if(status == 'Selesai'){
                return "<div id='popup"+id+"' class='overlay'><div class='popup'><h2>Detail Info</h2><a href='#' class='close'>&times;</a><div style='text-align: center' class='content'><h4>Nama Kerusakan : "+nama+"</h4><h4>Level Kerusakan : "+level+"</h4><h4>Status Kerusakan :  Perbaikan</h4><h4>Tanggal Perbaikan : </h4><h4>Foto :</h4><a href='/gambar/kerusakan/ori/"+foto1+"'><img src='/gambar/kerusakan/thumbnail/"+foto1+"' alt=''></a><a href='/gambar/kerusakan/ori/"+foto2+"'><img src='/gambar/kerusakan/thumbnail/"+foto2+"' alt=''></a><a href='/gambar/kerusakan/ori/"+foto3+"'><img src='/gambar/kerusakan/thumbnail/"+foto3+"' alt=''></a></div></div></div>";
            }
        }
    </script>
    <script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"></script>
    <script src="{{asset('js/leaflet-routing-machine.js')}}"></script>
    <script src="https://unpkg.com/leaflet.icon.glyph@0.2.0/Leaflet.Icon.Glyph.js"></script>
    <script src="{{asset('js_admin/ajax.js')}}"></script>
    <script src="{{asset('js_admin/config.js')}}"></script>
    <script src="{{asset('js_admin/show_map.js')}}"></script>
    @if (Auth::check())
        <script>
            var id = {{Auth::user()->id}};
        
            var pusher = new Pusher('c70441997e3d2b65ebed', {
            cluster: 'ap1',
            forceTLS: true
            });
        
            var channel = pusher.subscribe('my-channel');
            channel.bind('App\\Events\\sendName', function(data) {
            if(id == data.id){
                alert(data.text);
            }
            });
        </script>
    @endif
    
</body>
</html>