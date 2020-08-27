@extends('user.lay')

@section('head')
<link rel="stylesheet" href="{{asset('style_user/entry.css')}}">
<link rel="stylesheet" href="{{asset('bs/pagination.css')}}">
<style>
    .blog-author h3::before,
    .blog-author--no-cover h3::before {
        background-size: 60px;
    }
</style>
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
              <div style="background: url("/gambar/user/{{$sw->photo}}");" class="blog-author--no-cover">
                  <h3>{{$sw->pengirim}}</h3>
              </div>
            </div>
          
            <div class="blog-body">
              <div class="blog-title">
                <h1><a href="#">Judul : {{$sw->nama}}</a></h1>
                <a href="/gambar/laporan/ori/{{$sw->foto1}}"><img src="/gambar/laporan/thumbnail/{{$sw->foto1}}" alt=""></a>
              </div>
              <div class="blog-summary">
                <p>Keterangan : {{$sw->keterangan}}.</p>
              </div>
            </div>

            @if ($sw->status == 2)
            <div class="blog-body">
              <div class="blog-title">
                <h1><a href="#">Survey</a></h1>
                <a href="/gambar/survey/ori/{{$sw->foto}}"><img style="margin-bottom: 10px" src="/gambar/survey/thumbnail/{{$sw->foto}}" alt="" width="100px" height="auto"></a>
              </div>
            </div>
            @endif
            
            <div class="blog-footer">
              <ul>
                <li class="published-date">{{$sw->created_at->diffForHumans()}}</li>
                <li>
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
@endsection