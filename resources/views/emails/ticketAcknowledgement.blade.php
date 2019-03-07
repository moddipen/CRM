@component('mail::message')
# Ticket Acknowledgement

{{-- Body --}}
<p> Hello  , </p>
<p> Mail From : {!!  $data['name'] !!} </p>
<p>Title : {!! $data['title'] !!} </p>
<p> {!! $data['ticket_number'] !!} </p>
<p> {!! $data['description'] !!} </p><br>
<p> {!! $data['message'] !!} </p>
<p> {!! $data['comment'] !!}</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent

