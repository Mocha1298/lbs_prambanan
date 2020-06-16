@extends('admin.template')

@section('title','Dashboard')

@section('head')
<link rel="stylesheet" href="{{asset('style_admin/alert.css')}}">
@endsection

@section('breadcrump')
    Dashboard
@endsection

@section('isi')
    @if (session('success'))
    {{session('success')}}
    @endif
@endsection