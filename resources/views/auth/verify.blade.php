<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        body{
            margin:0;
            color:#6a6f8c;
            background:#c8c8c8;
            font:600 16px/18px 'Open Sans',sans-serif;
        }
        *,:after,:before{box-sizing:border-box}
        .clearfix:after,.clearfix:before{content:'';display:table}
        .clearfix:after{clear:both;display:block}
        a{color:inherit;text-decoration:none}

        .login-wrap{
            width:100%;
            margin:auto;
            margin-top: 10%;
            max-width:525px;
            min-height:400px;
            position:relative;
            background:url(https://raw.githubusercontent.com/khadkamhn/day-01-login-form/master/img/bg.jpg) no-repeat center;
            box-shadow:0 12px 15px 0 rgba(0,0,0,.24),0 17px 50px 0 rgba(0,0,0,.19);
        }
        .login-html{
            width:100%;
            height:100%;
            position:absolute;
            padding:90px 70px 50px 70px;
            background:rgba(40,57,101,.9);
        }
        .login-html .sign-in,
        .login-form .group .check{
            display:none;
        }
        .login-html .tab,
        .login-form .group .label,
        .login-form .group .button{
            text-transform:uppercase;
        }
        .login-html .tab{
            font-size:22px;
            margin-right:15px;
            padding-bottom:5px;
            margin:0 15px 10px 0;
            display:inline-block;
            border-bottom:2px solid transparent;
        }
        .login-html .sign-in:checked + .tab{
            color:#fff;
            border-color:#1161ee;
        }

        .hr{
            height:2px;
            margin:60px 0 50px 0;
            background:rgba(255,255,255,.2);
        }
        .foot-lnk{
            text-align:center;
        }
        p{
            color: white;
        }
        a:hover{
            color: tomato; 
        }
    </style>
    <title>AKSES DICEGAH</title>
</head>
<body>
    <div class="login-wrap">
        <div class="login-html">
            <input type="radio" class="sign-in" checked><label for="tab-1" class="tab">AKSES ANDA DICEGAH</label>
            <div class="login-form">
                <div class="sign-in-htm">
                <p>{{ __('Verifikasi email Anda') }}</p>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            <p>{{ __('Email Verifikasi telah terkirim, silahkan cek email Anda.') }}</p>
                        </div>
                    @endif

                    <p>{{ __('Akses dicegah, mohon periksa email Anda untuk melakukan verifikasi.') }}
                    {{ __('Jika Anda belum menerima email silahkan ') }}, <a href="{{ route('verification.resend') }}">{{ __('klik disini') }}</a></p>.

                    <p><a href="/">Kembali ke beranda...</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
