{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        body {
        background: #ABCDEF;
        font-family: Assistant, sans-serif;
        display: flex;
        min-height: 90vh;
        }
        .login {
        color: white;
        background: background: #136a8a;
        background: 
            -webkit-linear-gradient(to right, #267871, #136a8a);
        background: 
            linear-gradient(to right, #267871, #136a8a);
        margin: auto;
        box-shadow: 
            0px 2px 10px rgba(0,0,0,0.2), 
            0px 10px 20px rgba(0,0,0,0.3), 
            0px 30px 60px 1px rgba(0,0,0,0.5);
        border-radius: 8px;
        padding: 50px;
        }
        .login .head {
        display: flex;
        align-items: center;
        justify-content: center;
        }
        .login .head .company {
        font-size: 2.2em;
        }
        .login .msg {
        text-align: center;
        }
        .login .form input[type=text].text {
        border: none;
        background: none;
        box-shadow: 0px 2px 0px 0px white;
        width: 100%;
        color: white;
        font-size: 1em;
        outline: none;
        }
        .login .form .text::placeholder {
        color: #D3D3D3;
        }
        .login .form input[type=password].password {
        border: none;
        background: none;
        box-shadow: 0px 2px 0px 0px white;
        width: 100%;
        color: white;
        font-size: 1em;
        outline: none;
        margin-bottom: 20px;
        margin-top: 20px;
        }
        .login .form .password::placeholder {
        color: #D3D3D3;
        }
        .login .form .btn-login {
        background: none;
        text-decoration: none;
        color: white;
        box-shadow: 0px 0px 0px 2px white;
        border-radius: 3px;
        padding: 5px 2em;
        transition: 0.5s;
        }
        .login .form .btn-login:hover {
        background: white;
        color: dimgray;
        transition: 0.5s;
        }
        .login .forgot {
        text-decoration: none;
        color: white;
        float: right;
        }
        .success{
            margin-bottom: 20px; 
            color: rgb(245, 68, 68);
            background: rgb(241, 238, 69);
            text-align: center;
            font-style: oblique;
            font-size: 20px;
        }
        a.dashboard{
            color: white;
            text-decoration: none;
        }
        a.dashboard:hover{
            color: grey;
        }
    </style>
    <title>LOGIN</title>
</head>
<body>
    <section class='login' id='login'>
        <div class='head'>
        <img src="https://pxntxs.github.io/templates/login-page/i/telescope.png">
        <h1 class='company'>PETANE PRAMBANAN</h1>
        </div>
        @if (Auth::check())
            @if (Auth::user()->roles_id != 3)
                <p style="text-align: center">Anda sudah login....==> <a class="dashboard" href="/super">Dashboard</a></p>
            @else
                <p style="text-align: center">Anda sudah login....==> <a class="dashboard" href="/">Home</a></p>
            @endif
        @else
            <p class='msg'>Selamat Datang</p>
            <div class='form'>
                <form method="post" action="{{ route('login') }}">
                    {{csrf_field()}}
                    @if (session('gagal'))
                    <div class="success">{{session('gagal')}}</div>
                    @endif
                    <input name="nama" autocomplete="off" type="text" placeholder='Username' class='text' id='username' required>
                    <br>
                    <input name="password" type="password" placeholder='Password' class='password'>
                    <br>
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                    <button class='btn-login'>Login</button>
                    <a href="#" class='forgot'>Lupa Password</a>
                </form>
            </div>
        @endif
    </section>
</body>
</html>
   --}}
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
            max-width:525px;
            min-height:670px;
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
        .login-html .sign-in-htm,
        .login-html .sign-up-htm{
            top:0;
            left:0;
            right:0;
            bottom:0;
            position:absolute;
            transform:rotateY(180deg);
            backface-visibility:hidden;
            transition:all .4s linear;
        }
        .login-html .sign-in,
        .login-html .sign-up,
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
        .login-html .sign-in:checked + .tab,
        .login-html .sign-up:checked + .tab{
            color:#fff;
            border-color:#1161ee;
        }
        .login-form{
            min-height:345px;
            position:relative;
            perspective:1000px;
            transform-style:preserve-3d;
        }
        .login-form .group{
            margin-bottom:15px;
        }
        .login-form .group .label,
        .login-form .group .input,
        .login-form .group .button{
            width:100%;
            color:#fff;
            display:block;
        }
        .login-form .group .input,
        .login-form .group .button{
            border:none;
            padding:15px 20px;
            border-radius:25px;
            background:rgba(255,255,255,.1);
        }
        .login-form .group input[data-type="password"]{
            text-security:circle;
            -webkit-text-security:circle;
        }
        .login-form .group .label{
            color:#aaa;
            font-size:12px;
        }
        .login-form .group .button{
            background:#1161ee;
        }
        .login-form .group label .icon{
            width:15px;
            height:15px;
            border-radius:2px;
            position:relative;
            display:inline-block;
            background:rgba(255,255,255,.1);
        }
        .login-form .group label .icon:before,
        .login-form .group label .icon:after{
            content:'';
            width:10px;
            height:2px;
            background:#fff;
            position:absolute;
            transition:all .2s ease-in-out 0s;
        }
        .login-form .group label .icon:before{
            left:3px;
            width:5px;
            bottom:6px;
            transform:scale(0) rotate(0);
        }
        .login-form .group label .icon:after{
            top:6px;
            right:0;
            transform:scale(0) rotate(0);
        }
        .login-form .group .check:checked + label{
            color:#fff;
        }
        .login-form .group .check:checked + label .icon{
            background:#1161ee;
        }
        .login-form .group .check:checked + label .icon:before{
            transform:scale(1) rotate(45deg);
        }
        .login-form .group .check:checked + label .icon:after{
            transform:scale(1) rotate(-45deg);
        }
        .login-html .sign-in:checked + .tab + .sign-up + .tab + .login-form .sign-in-htm{
            transform:rotate(0);
        }
        .login-html .sign-up:checked + .tab + .login-form .sign-up-htm{
            transform:rotate(0);
        }

        .hr{
            height:2px;
            margin:60px 0 50px 0;
            background:rgba(255,255,255,.2);
        }
        .foot-lnk{
            text-align:center;
        }
    </style>
    <title>Document</title>
</head>
<body>
    <div class="login-wrap">
        <div class="login-html">
            <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Sign In</label>
            <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Sign Up</label>
            <div class="login-form">
                <div class="sign-in-htm">
                    <div class="group">
                        <label for="user" class="label">Username</label>
                        <input name="nama" id="user" type="text" class="input">
                    </div>
                    <div class="group">
                        <label for="pass" class="label">Password</label>
                        <input name="password" id="pass" type="password" class="input" data-type="password">
                    </div>
                    <div class="group">
                        <input id="check" type="checkbox" class="check" checked>
                        <input id="check" class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="check"><span class="icon"></span> Keep me Signed in</label>
                    </div>
                    <div class="group">
                        <input type="submit" class="button" value="Sign In">
                    </div>
                    <div class="hr"></div>
                    <div class="foot-lnk">
                        <a href="#forgot">Forgot Password?</a>
                    </div>
                </div>
                <div class="sign-up-htm">
                    <div class="group">
                        <label for="user" class="label">Username</label>
                        <input id="user" type="text" class="input">
                    </div>
                    <div class="group">
                        <label for="pass" class="label">Password</label>
                        <input id="pass" type="password" class="input" data-type="password">
                    </div>
                    <div class="group">
                        <label for="pass" class="label">Repeat Password</label>
                        <input id="pass" type="password" class="input" data-type="password">
                    </div>
                    <div class="group">
                        <label for="pass" class="label">Email Address</label>
                        <input id="pass" type="text" class="input">
                    </div>
                    <div class="group">
                        <input type="submit" class="button" value="Sign Up">
                    </div>
                    <div class="hr"></div>
                    <div class="foot-lnk">
                        <label for="tab-1">Already Member?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>