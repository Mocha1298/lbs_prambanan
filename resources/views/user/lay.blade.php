<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{asset('/gambar/logo/logo.png')}}">
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC|Raleway" rel="stylesheet">
    <script src="https://use.fontawesome.com/46ea1af652.js"></script>
    <link rel="stylesheet" href="{{asset('style_user/layout.css')}}">
    <script src="{{asset('jquery/jquery.js')}}"></script>
    <script src="https://js.pusher.com/6.0/pusher.min.js"></script>
    <title>@yield('title')</title>
    @yield('head')
</head>
<body>
    <header class="topnav" id="myTopnav">
        <a href="/"><img class="logo" src="{{asset('/logo/peta-jalan.png')}}" alt="Smiley face"></a>
        <div class="navlist" id="navlist">
            <a class="cursor0" href="/">&nbsp</a>
            <a class="navoption" href="/">Home</a>
            @if (auth::check())
                @yield('profile')
            @endif
            <a class="navoption" href="/laporan">Laporan</a>
            @if (Auth::check())
            <a class="navoption" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
            @else
            <a href="login" class="navoption">Login</a>
            @endif
            <a href="javascript:void(0);" class="icon" id="hamburger">
                <i class="fa fa-bars"></i>
            </a>
        </div>
    </header>
    @yield('isi')
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
</body>
</html>