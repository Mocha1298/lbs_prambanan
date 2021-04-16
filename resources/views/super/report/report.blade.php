@extends('super.template')

@section('title','LAPORAN')

@section('head')
  <link rel="stylesheet" href="{{asset('style_admin/table.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/form.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/popup.css')}}">
  <link rel="stylesheet" href="{{asset('bs/pagination.css')}}">
  <script src="{{asset('jquery/jquery.js')}}"></script>
@endsection
@section('copy')
oncopy='return false' oncut='return false' onpaste='return false'
@endsection
@section('breadcrump')
    Laporan
@endsection
@section('isi')
<div class="isi">
  <style>
    .filter button{
      padding:0 20px;
    }
  </style>
  <a class="filter" href="#filter"><button><i class="fa fa-filter fa-2x"></i></button></a>
    <table>
      <caption>Tabel Laporan</caption>
      <thead>
        <tr>
          <th scope="col">No</th>
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
          @foreach ($data as $nomor => $lap)
            <tr class="table">
              <td data-label="No">{{ $nomor + $data->firstitem()}}</td>
                <td data-label="Judul">{{$lap->nama}}</td>
                <td data-label="Pengirim">{{$lap->sender}}</td>
                <td data-label="Desa">{{$lap->desa}}</td>
                <td data-label="Status">
                  @if ($lap->status == 1)
                  Diterima
                  @elseif($lap->status == 2)
                  Disetujui
                  @else
                  Valid
                  @endif
                </td>
                <td data-label="Masuk">{{date('d F Y', strtotime($lap->created_at))}}</td>
                <td data-label="Setuju">@if($lap->setuju){{date('d F Y', strtotime($lap->setuju))}}@else - @endif</td>
                <td data-label="Valid">@if($lap->valid){{date('d F Y', strtotime($lap->valid))}}@else - @endif</td>
            </tr>
          @endforeach
    </tbody>
    </table>
    {{$data->links()}}
    <style>
      .cetak button{
        padding:0 20px;
      }
    </style>
</div>
{{-- POPUP filter DATA --}}
<div id="filter" class="overlay">
  <div class="popup">
    <h2>Filter</h2>
    <a class="close" href="#">&times;</a>
    <div class="content">
      <div class="filter">
        <form id="form" action="/report/period" method="get">
          <fieldset>
            <select name="filter" id="">
              <option value="texts.created_at">Tanggal Masuk</option>
              <option value="agendas.created_at">Tanggal Acc</option>
              <option value="maps.created_at">Tanggal Valid</option>
            </select>
          </fieldset>
          <fieldset>
            <label for="dari">Dari Tanggal</label>
            <input id="dari" oninput="setmin();" max="{{date('Y-m-d')}}" name="dari" type="date" value="{{date('Y-m-d')}}">
          </fieldset>
          <fieldset>
            <label for="sampai">Sampai Tanggal</label>
            <input id="sampai" oninput="setmax();" name="sampai" min="{{date('Y-m-d')}}" type="date" value="{{date('Y-m-d')}}">
          </fieldset>
          <button type="submit" name="submit" value="print"><i class="fa fa-print fa-2x"></i></button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
    <script>
      function setmin() {
        var value = $("#dari")[0].value;
        $("#sampai")[0].min = value;
        // console.log($("#sampai")[0].min);
      }
      function setmax() {
        var value = $("#sampai")[0].value;
        $("#dari")[0].max = value;
        // console.log($("#dari")[0].max);
      }
    </script>
@endsection