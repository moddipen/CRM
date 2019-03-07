@component('mail::message')
# Acknowledgement

{{-- Body --}}
<p> Hello  , </p>
<p> Mail From : {!!  $data['name'] !!} </p>
<p>Title : {!! $data['title'] !!} </p>
<p> {!! $data['message'] !!} </p>
<p> {!! $data['comment'] !!} </p><br>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
