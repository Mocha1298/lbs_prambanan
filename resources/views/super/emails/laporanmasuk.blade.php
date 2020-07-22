@component('mail::message')
# {{$details['title']}}

{{$details['body']}}

@component('mail::button', ['url' => '{{$detail["notice"]}}'])
Lihat Laporan
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
