@extends('super.template')

@section('title','LAPORAN')

@section('head')
  <link rel="stylesheet" href="{{asset('style_admin/table.css')}}">
@endsection
@section('copy')
oncopy='return false' oncut='return false' onpaste='return false'
@endsection
@section('breadcrump')
    Laporan
@endsection
@section('isi')
<div class="isi">
    <table>
      <caption>Tabel Laporan</caption>
      <thead>
        <tr>
          <th scope="col">Judul</th>
          <th scope="col">Pengirim</th>
          <th scope="col">Desa</th>
          <th scope="col">Status</th>
          <th scope="col">Masuk</th>
          <th scope="col">Setuju</th>
          <th scope="col">Valid</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($data as $lap)
            <tr class="table">
                <td data-label="Judul">{{$lap->nama}}</td>
                <td data-label="Pengirim">{{$lap->sender}}</td>
                <td data-label="Desa">{{$lap->desa}}</td>
                <td data-label="Status">Diterima</td>
                <td data-label="Masuk">{{$lap->created_at}}</td>
                <td data-label="Setuju">{{$lap->setuju}}</td>
                <td data-label="Valid">{{$lap->valid}}</td>
            </tr>
          @endforeach
    </tbody>
    </table>
</div>
@endsection