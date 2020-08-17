<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://use.fontawesome.com/46ea1af652.js"></script>
    <script src="{{asset('jquery/jquery.js')}}"></script>
    <title>LAPORAN</title>
    <style>
        body{
            margin: 0;
        }
        .container{
            width: 950px;
            background-color: white;
        }
        table,
        th,
        td {
        border: 1px solid black;
        padding-right: 10px;
        padding-left: 10px;
        }
        table {
        border-collapse: collapse;
        }

        tr:nth-child(even) {
        background-color: lightgrey;
        }

        th {
        background-color: skyblue;
        }

        #table {
            margin: auto;
            width: 900px;
            margin-bottom: 100px;
        }
        header{
            display: flex;
            justify-content: space-between;
        }
        .logo{
            padding: 10px 20px;
        }
        .logo img{
            width: 100px;
            height: auto;
        }
        .judul{
            text-align: center;
        }
        tr.tebal{
            font-weight: bold;
        }
        a.cetak{
            margin-top: 100px;
        }
        .cetak button{
            width: 80px;
        }
        .kop{
            text-align: center;
        }
        hr{
            margin: 2px 0;
        }
        hr.tebal{
            border: 2px solid black; 
        }
    </style>
</head>
<body>
<div class="container">
    <header>
        <div class="logo">
            <img src="{{asset('gambar/logo/logo.png')}}" alt="">
        </div>
        <div class="kop">
            <h1>Pemerintah Kecamatan Prambanan Kabupaten Klaten</h1>
            <p>Alamat : Jl. Jogja-Solo Km 13 Tlogo, Prambanan, Klaten</p>
        </div>
    </header>
    <hr class="tebal">
    <hr>
    <div id="table">
        <h1 class="judul">Laporan Suara Warga</h1>
        <table>
            <tr>
                <td>No</td>
                <td data-label="Judul">Judul</td>
                <td data-label="Pengirim">Pengirim</td>
                <td data-label="Desa">Desa</td>
                <td data-label="Status">Status</td>
                <td data-label="Masuk">Masuk</td>
                <td data-label="Setuju">Setuju</td>
                <td data-label="Valid">Valid</td>
            </tr>
                @foreach ($hasil as $lap)
                <tr class="table">
                    <td>{{$loop->iteration}}</td>
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
                    <td data-label="Masuk">{{$lap->created_at}}</td>
                    <td data-label="Setuju">{{$lap->setuju}}</td>
                    <td data-label="Valid">{{$lap->valid}}</td>
                </tr>
              @endforeach
        </table>
    </div>
</div>
<script>
    $(document).ready(function(){
    window.print();
    });
</script>
</body>
</html>