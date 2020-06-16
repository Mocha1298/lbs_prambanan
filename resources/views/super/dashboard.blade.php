@extends('super.template')

@section('title','Dashboard')

@section('head')
<link rel="stylesheet" href="{{asset('style_admin/alert.css')}}">
<link rel="stylesheet" href="{{asset('style_admin/card.css')}}">
@endsection

@section('breadcrump')
    Dashboard
@endsection

@section('isi')
<ul class="card-container">
  <li class="card user">
    <div class="logo">
      <i class="fa fa-user fa-3x"></i>
    </div>
    <div class="title">
      <div class="name">PENGGUNA</div>
      <div class="number">{{$data1}}</div>
    </div>
    <a href="/master_user">
      <div class="detail">
        <i class="fa fa-arrow-right fa-3x"></i>
      </div>
    </a>
  </li>
  <li class="card kecamatan">
    <div class="logo">
      <i class="fa fa-users fa-3x"></i>
    </div>
    <div class="title">
      <div class="name">KECAMATAN</div>
      <div class="number">{{$data2}}</div>
    </div>
    <a href="/master_kecamatan">
      <div class="detail">
        <i class="fa fa-arrow-right fa-3x"></i>
      </div>
    </a>
  </li>
  <li class="card kerusakan">
    <div class="logo">
      <i class="fa fa-map fa-3x"></i>
    </div>
    <div class="title">
      <div class="name">KERUSAKAN</div>
      <div class="number">{{$data3}}</div>
    </div>
    <a href="/objek_kerusakan">
      <div class="detail">
        <i class="fa fa-arrow-right fa-3x"></i>
      </div>
    </a>
  </li>
  <li class="card laporan">
    <div class="logo">
      <i class="fa fa-file fa-3x"></i>
    </div>
    <div class="title">
      <div class="name">LAPORAN</div>
      <div class="number">{{$data4}}</div>
    </div>
    <a href="/lapor_lapor1">
      <div class="detail">
        <i class="fa fa-arrow-right fa-3x"></i>
      </div>
    </a>
  </li>
</ul>
@endsection