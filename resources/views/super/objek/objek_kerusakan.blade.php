@extends('super.template')

@section('title','Objek Kerusakan')

@section('head')
  <link rel="stylesheet" href="{{asset('style_admin/table.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/popup.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/form.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/action.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/alert.css')}}">
  <link rel="stylesheet" href="{{asset('style_admin/button.css')}}">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
  integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
  crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
  <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <style>
      #mapid{
          width: 100%;
          height: 85%;
      }
  </style>
  <script src="{{asset('jquery/jquery-3.5.1.slim.min.js')}}"></script>
  <script src="{{asset('js_admin/nav.js')}}"></script>
@endsection
@section('copy')
oncopy='return false' oncut='return false' onpaste='return false'
@endsection
@section('breadcrump')
    Objek Kerusakan
@endsection
@section('isi')
    <h1 class="title">Peta Kerusakan</h1>
    <div id="mapid"></div>
@endsection
@section('script')
    <script>
      function readURL(input) {
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
              $('#blah')
                    .attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]); // convert to base64 string
          }
        }

        $("#imgInp").change(function() {
          readURL(this);
        });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>
    <script src="{{asset('js_admin/pollygon.js')}}"></script>
    <script src="{{asset('js_admin/bundle.js')}}"></script>
    <script src="{{asset('js_admin/map.js')}}"></script>
@endsection