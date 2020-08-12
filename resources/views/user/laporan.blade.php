@extends('user.lay')

@section('head')
<link rel="stylesheet" href="{{asset('style_user/entry.css')}}">
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
  <a class="navoption" href="/my_suwar/{{Auth::user()->id}}">Profile</a>
  @endsection
@endif
<svg display="none" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <defs>
        <symbol id="icon-bubble" viewBox="0 0 1024 1024">
            <title>bubble</title>
            <path class="path1" d="M512 224c8.832 0 16 7.168 16 16s-7.2 16-16 16c-170.464 0-320 89.728-320 192 0 8.832-7.168 16-16 16s-16-7.168-16-16c0-121.408 161.184-224 352-224zM512 64c-282.784 0-512 171.936-512 384 0 132.064 88.928 248.512 224.256 317.632 0 0.864-0.256 1.44-0.256 2.368 0 57.376-42.848 119.136-61.696 151.552 0.032 0 0.064 0 0.064 0-1.504 3.52-2.368 7.392-2.368 11.456 0 16 12.96 28.992 28.992 28.992 3.008 0 8.288-0.8 8.16-0.448 100-16.384 194.208-108.256 216.096-134.88 31.968 4.704 64.928 7.328 98.752 7.328 282.72 0 512-171.936 512-384s-229.248-384-512-384zM512 768c-29.344 0-59.456-2.24-89.472-6.624-3.104-0.512-6.208-0.672-9.28-0.672-19.008 0-37.216 8.448-49.472 23.36-13.696 16.672-52.672 53.888-98.72 81.248 12.48-28.64 22.24-60.736 22.912-93.824 0.192-2.048 0.288-4.128 0.288-5.888 0-24.064-13.472-46.048-34.88-56.992-118.592-60.544-189.376-157.984-189.376-260.608 0-176.448 200.96-320 448-320 246.976 0 448 143.552 448 320s-200.992 320-448 320z"></path>
        </symbol>
        <symbol id="icon-star" viewBox="0 0 1024 1024">
            <title>star</title>
            <path class="path1" d="M1020.192 401.824c-8.864-25.568-31.616-44.288-59.008-48.352l-266.432-39.616-115.808-240.448c-12.192-25.248-38.272-41.408-66.944-41.408s-54.752 16.16-66.944 41.408l-115.808 240.448-266.464 39.616c-27.36 4.064-50.112 22.784-58.944 48.352-8.8 25.632-2.144 53.856 17.184 73.12l195.264 194.944-45.28 270.432c-4.608 27.232 7.2 54.56 30.336 70.496 12.704 8.736 27.648 13.184 42.592 13.184 12.288 0 24.608-3.008 35.776-8.992l232.288-125.056 232.32 125.056c11.168 5.984 23.488 8.992 35.744 8.992 14.944 0 29.888-4.448 42.624-13.184 23.136-15.936 34.88-43.264 30.304-70.496l-45.312-270.432 195.328-194.944c19.296-19.296 25.92-47.52 17.184-73.12zM754.816 619.616c-16.384 16.32-23.808 39.328-20.064 61.888l45.312 270.432-232.32-124.992c-11.136-6.016-23.424-8.992-35.776-8.992-12.288 0-24.608 3.008-35.744 8.992l-232.32 124.992 45.312-270.432c3.776-22.56-3.648-45.568-20.032-61.888l-195.264-194.944 266.432-39.68c24.352-3.616 45.312-18.848 55.776-40.576l115.872-240.384 115.84 240.416c10.496 21.728 31.424 36.928 55.744 40.576l266.496 39.68-195.264 194.912z"></path>
        </symbol>
    </defs>
</svg>
<div class="add-data">
  <h2><a href="/suwar">TAMBAH LAPORAN <i class="fa fa-plus"></i></a></h2>
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
                <li class="published-date">{{$sw->created_at}}</li>
                <li class="shares"><svg style="@if ($sw->status == 2)
                  fill: #ff4d4d;
                @endif" class="icon-star"><use xlink:href="#icon-star"></use></svg></li>
              </ul>
            </div>
          
        </div>
    @endforeach
    <div class="pagination">
      <?php
        // config
        $link_limit = 5;
        ?>

        @if ($laporan->lastPage() > 1)
            <ul>
                <li class="{{ ($laporan->currentPage() == 1) ? ' disabled' : '' }}">
                    <a href="{{ $laporan->url(1) }}">First</a>
                </li>
                @for ($i = 1; $i <= $laporan->lastPage(); $i++)
                    <?php
                    $half_total_links = floor($link_limit / 2);
                    $from = $laporan->currentPage() - $half_total_links;
                    $to = $laporan->currentPage() + $half_total_links;
                    if ($laporan->currentPage() < $half_total_links) {
                      $to += $half_total_links - $laporan->currentPage();
                    }
                    if ($laporan->lastPage() - $laporan->currentPage() < $half_total_links) {
                        $from -= $half_total_links - ($laporan->lastPage() - $laporan->currentPage()) - 1;
                    }
                    ?>
                    @if ($from < $i && $i < $to)
                        <li class="{{ ($laporan->currentPage() == $i) ? ' active' : '' }}">
                            <a href="{{ $laporan->url($i) }}">{{ $i }}</a>
                        </li>
                    @endif
                @endfor
                <li class="{{ ($laporan->currentPage() == $laporan->lastPage()) ? ' disabled' : '' }}">
                    <a href="{{ $laporan->url($laporan->lastPage()) }}">Last</a>
                </li>
            </ul>
        @endif
  </div>
@endsection