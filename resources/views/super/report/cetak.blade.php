<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LAPORAN</title>
    <style>
        html{
            background-color: gray;
        }
        .container{
            width: 950px;
            margin: auto;
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

        #event-table {
        margin-left: 250px;
        margin-top: 50px;
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
    </style>
</head>
<body>
<div class="container">
    <header>
        <div class="logo">
            <img src="{{asset('gambar/logo/logo.png')}}" alt="">
        </div>
        <div class="kop">
            <h2>Pemerintah Kecamatan Prambanan Kabupaten Klaten</h2>
            <p>Alamat : Tlogo, Prambanan, Klaten.</p>
        </div>
    </header>
    <div id="table">
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
            <tr>
                @foreach ($data as $lap)
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
            </tr>
        </table>
    </div>
</div>
</body>
</html>