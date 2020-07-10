<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Peta-Jalan</title>
        <link href="https://fonts.googleapis.com/css?family=Amatic+SC|Raleway" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <link rel="stylesheet" href="{{asset('style_user/lp-style.css')}}">
    </head>
    <body>
        <div class="float-sm">
            <div class="fl-fl float-sw">
                <a href="/suwar"> Suara Warga!</a>
                <i class="fa fa-flag-checkered fa-4x"></i>
            </div>
        </div>
    <!-- Forked from a template on Tutorialzine: https://tutorialzine.com/2016/06/freebie-landing-page-template-with-flexbox -->
        <a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>
        <header>
            <h2><a href="/">Peta-Jalan</a></h2>
            <nav>
            <li><a href="#apa">Apa itu?</a></li>
            <li><a href="#fitur">Fitur</a></li>
            <li><a href="#bergabung">Bergabung</a></li>
            @if (Auth::check())
                @if (Auth::user()->roles_id == 1 || Auth::user()->roles_id == 2)
                    <li><a href="/admin">Admin</a></li>
                @else
                    <li><a href="/my_suwar">Profile</a></li>
                @endif
                <li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                     @csrf
                 </form></li>
            @else
                <li><a href="login">Login</a></li>
            @endif
            </nav>
        </header>

        <section class="hero">
            <div class="background-image"></div>
            <div class="hero-content-area">
            <h1>Peta-Jalan</h1>
            <h3>Petanya Kerusakan Jalan Tingkat Desa...</h3>
            <a href="/maps" class="btn">Lihat Peta</a>
            </div>
        </section>

        <section class="packages" id="apa">
            <h3 class="title">Apa itu Peta-Jalan</h3>
            <p>Kami menawarkan sebuah halaman website yang dapat mempermudah Anda untuk mengakses informasi kerusakan jalan dan bangunan pada setiap desa yang ada di Kecamatan Pramabanan. Dengan informasi yang sangat mendetail mulai dari titik lokasi kerusakan, keadaan sebelum kerusakan dan setelah perbaikan.</p>
            <hr>

            <ul class="grid" id="fitur">
            <li>
                <i class="fa fa-compass fa-4x"></i>
                <h4>Peta Kerusakan</h4>
                <p>Kami dapat menampilkan seluruh informasi jalan rusak yang ada di seluruh desa yang ada di Kecamatan Prambanan.</p>
            </li>
            <li>
                <i class="fa fa-camera-retro fa-4x"></i>
                <h4>Ilustrasi Kerusakan</h4>
                <p>Mengilustrasikan keadaan menggunakan kalimat sangat sulit dimengerti, dengan Peta-Jalan ini kami dapat menampilkan gambar real dari keadaan kerusakan mulai dari sebelum perbaikan sampai setelah perbaikan.</p>
            </li>
            <li>
                <i class="fa fa-bicycle fa-4x"></i>
                <h4>Pelacak Jalan</h4>
                <p>Jika Anda adalah orang yang suka dengan bersepeda untuk melihat suasana dan keindahan dari Kecamatan Prambanan maka dengan bantuan kami Anda akan mendapat informasi rute perjalanan Anda untuk sampai ke tujuan.</p>
            </li>
            <li>
                <i class="fa fa-flag-checkered fa-4x"></i>
                <h4>Suara Warga</h4>
                <p>Anda menemukan kerusakan baru? Tenang saja, kami juga menyediakan fitur pelaporan informasi yang dapat Anda gunakan. Fitur ini bertujuan untuk membuka kesempatan kepada Anda sebagai masyarakat untuk memberikan aspirasinya kepada kami.</p>
            </li>
            </ul>
        </section>

        <section class="contact" id="bergabung">
            <h3 class="title">Bergabung?</h3>
            <p>Ingin bergabung dengan kami? jika Anda ingin ikut berpartisipasi dengan kami untuk berbagi informasi kerusakan jalan yang ada di Kecataman Prambanan ini Anda cukup melakukan Pendaftaran dengan cara mengisi form setelah menekan tombol dibawah ini.</p>
            <hr>
            <form method="post" action="/bergabung">
                @csrf
                <input name="email" type="email" placeholder="Tuliskan Email Anda" required autocomplete="off">
                <button @if(Auth::check()) disabled @endif type="submit" class="btn">Bergabung</button>
            </form>
        </section>

        <footer>
            <p>Peta-Jalan</p>
            <p>menemukan kesalahan? silahkan hubungi develper kami <a href="https://forms.gle/tkp4mBvWLdV7qeKY7">*klik disini*</a></p>
            <ul>
            <li><a href="#"><i class="fa fa-twitter-square fa-2x"></i></a></li>
            <li><a href="#"><i class="fa fa-facebook-square fa-2x"></i></a></li>
            <li><a href="#"><i class="fa fa-snapchat-square fa-2x"></i></a></li>
            </ul>
        </footer>
        <script>
            // ===== Scroll to Top ==== 
            $(window).scroll(function() {
                if ($(this).scrollTop() >= 50) {        // Scroll lebih 50px
                    $('#return-to-top').fadeIn(200);    // Efek muncul
                } else {
                    $('#return-to-top').fadeOut(200);   // Efek hilang

                }
            });
            $(window).scroll(function() {
                if ($(this).scrollTop() >= 500) {        // Scroll lebih 50px
                    $('header').css('background','rgba(2, 2, 2, 0.966)');
                } else {
                    $('header').css('background','rgba(2, 2, 2, 0.1)');

                }
            });
            $('#return-to-top').click(function() {      // Aksi ketika klik
                $('body,html').animate({
                    scrollTop : 0                       // Kembali ke atas
                }, 500);
            });
        </script>
    </body>
</html>
