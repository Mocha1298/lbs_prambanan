<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="{{asset('jquery/jquery.js')}}"></script>
  <link href="https://fonts.googleapis.com/css2?family=MuseoModerno:wght@600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('style_user/form.css')}}">
  <title>Document</title>
</head>
<body>
  <form method="post" action="{{url('captcha')}}">

    <div class="judul">
      <h3 id="logo">Suara Warga</h3>
      <h5>(Suara Warga adalah fitur pelaporan untuk Masyarakat kepada Pemerintah Desa terhadap kasus kerusakan jalan baru...)</h5>
    </div>
  
    <hr>

    <label for="nama">Judul Laporan</label>
    <input type="text" id="nama" name="nama" placeholder="Tulis Judul laporan Anda.." autocomplete="off" required />
  
    <label for="keterangan">Keterangan</label>
    <input type="text" id="keterangan" name="keterangan" placeholder="Tulis Keterangan laporan Anda.." autocomplete="off" required />

    <label for="desa">DESA</label>
    <select name="desa">
      <option class="dis" selected disabled>Pilih Desa laporan Anda..</option>
      @foreach ($data as $dt)
        <option value="{{$dt->id}}">{{$dt->nama}}</option>
      @endforeach
    </select>
    
    <label for="rw">RW (optional)</label>
    <input type="text" id="rw" name="rw" placeholder="Tulis  laporan Anda.." autocomplete="off" required />
    
    <label for="rt">RT (optional)</label>
    <input type="text" id="rt" name="rt" placeholder="Tulis judul laporan Anda.." autocomplete="off" required />
  
    <label for="username">Username</label>
    <input type="text" id="username" name="username" placeholder="Type in your username.." autocomplete="off" required />

    <label style="width: 100%" for="captcha">Captcha</label>
    <div class="captcha">
      <span>{!! captcha_img() !!}</span>
    </div>
    <div class="btn-refresh">
      <button id="refresh" type="button" class="refresh"><i class="fa fa-refresh"></i></button>
      {{-- <a href="#" id="refresh"></a> --}}
    </div>

    <input id="captcha" type="text" placeholder="Enter Captcha" name="captcha" autocomplete="off" required ></div>
    </div>
  
    <input type="submit" name="submit" value="Submit" />
  
  </form>
  <script type="text/javascript">
    $('#refresh').click(function(){
        $.ajax({
          type:'GET',
          url:'refreshcaptcha',
          success:function(data){
              $(".captcha span").html(data.captcha);
          }
        });
      });
  </script>
  <script>
  </script>
</body>
</html>