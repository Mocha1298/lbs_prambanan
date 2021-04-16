@extends('user.lay')

@section('head')
<link rel="stylesheet" href="{{asset('style_user/entry.css')}}">
<link rel="stylesheet" href="{{asset('bs/pagination.css')}}">
@endsection

@section('title','LAPORAN SUARA WARGA')
@section('active','active')

@section('isi')
@if (Auth::check())
  @section('profile')
  <a title="ke halaman profil" class="navoption" href="/my_suwar/{{Auth::user()->id}}">Profile</a>
  @endsection
@endif
<div class="add-data">
  <h2><a title="ke halaman tambah laporan" href="/suwar">TAMBAH LAPORAN <i class="fa fa-plus"></i></a></h2>
</div>
    @foreach ($laporan as $sw)
        <div class="blog-container">
  
            <div class="blog-header">
              <style>
                .blog-author h3::before,
                .blog-author--no-cover h3::before {
                  background: url('/gambar/user/{{$sw->photo}}');
                  background-size: cover;
                  border-radius: 50%;
                  content: " ";
                  display: inline-block;
                  height: 40px;
                  margin-right: .5rem;
                  position: relative;
                  top: 8px;
                  width: 40px;
                  /* border: 2px solid #ff4d4d; */
                }
              </style>
              <div class="blog-author--no-cover">
                  <h3>{{$sw->pengirim}}</h3>
              </div>
            </div>
          
            <div class="blog-body">
              <div class="blog-title">
                <h1><a>Judul : {{$sw->nama}}</a></h1>
                <a href="/gambar/laporan/ori/{{$sw->foto1}}"><img src="/gambar/laporan/thumbnail/{{$sw->foto1}}" alt=""></a>
              </div>
              <style>
                .blog-summary{
                  display: none;
                }
                .more{
                  margin-top: 20px;
                }
                .less{
                  display: none;
                }
                .more a{
                  cursor: pointer;
                  color: black;
                }
                .less a{
                  cursor: pointer;
                  color: black;
                }
              </style>
              <div class="more id{{$sw->id}}"><a onclick="return more({{$sw->id}})"><strong>SELENGKAPNYA</strong></a></div>
              <div class="blog-summary id{{$sw->id}}">
                <p>Keterangan : {{$sw->keterangan}}.</p>
                <p>Lokasi Kerusakan : </p>
                <p>RT : {{$sw->rt}}</p>
                <p>RW : {{$sw->rw}}</p>
                <p>Desa : {{$sw->desa}}</p>
              </div>
              <div class="less id{{$sw->id}}"><a onclick="return less({{$sw->id}});"><strong>SEMBUNYIKAN</strong></a></div>
            </div>

            @if ($sw->status == 2)
            <div class="blog-body">
              <div class="blog-title">
                <h1><a>Survey</a></h1>
                <a href="/gambar/survey/ori/{{$sw->foto}}"><img style="margin-bottom: 10px" src="/gambar/survey/thumbnail/{{$sw->foto}}" alt="" width="100px" height="auto"></a>
              </div>
            </div>
            @endif
            
            <div class="blog-footer">
              <ul>
                <li class="published-date">{{$sw->created_at->diffForHumans()}}</li>
                <li class="status">
                @if($sw->status == 1)
                  DITERIMA
                @elseif ($sw->status == 2)
                  DISURVEY
                @elseif($sw->status == 3)
                  VALID
                @endif
                </li>
              </ul>
            </div>
          
        </div>
    @endforeach
    <style>
      .jos{
        width: 100%;
        text-align: center;
      }
    </style>
    <div class="jos">
      {{$laporan->links()}}
    </div>
    <script>
      var mor;
      var les;
      
      function more(x){
        $(".more.id"+x).fadeOut("fast");
        $(".less.id"+x).fadeIn("fast");
        $(".blog-summary.id"+x).fadeIn("fast");
      }
      function less(x){
        $(".more.id"+x).fadeIn("fast");
        $(".less.id"+x).fadeOut("fast");
        $(".blog-summary.id"+x).fadeOut("fast");
      }
    </script>
@endsection