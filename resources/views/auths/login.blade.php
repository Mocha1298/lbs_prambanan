<!DOCTYPE html>
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
                <form method="post" action="/dashboard">
                    {{csrf_field()}}
                    @if (session('gagal'))
                    <div class="success">{{session('gagal')}}</div>
                    @endif
                    <input name="nama" autocomplete="off" type="text" placeholder='Username' class='text' id='username' required>
                    <br>
                    <input name="password" type="password" placeholder='Password' class='password'>
                    <br>
                    <button class='btn-login'>Login</button>
                    <a href="#" class='forgot'>Lupa Password</a>
                </form>
            </div>
        @endif
    </section>
</body>
</html>
  