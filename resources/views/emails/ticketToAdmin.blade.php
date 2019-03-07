@component('mail::message')
Ticket Details
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
Header Title
@endcomponent
@endslot

{{-- Body --}}
<p> Hello {!!  $data['adminName'] !!} , </p>
<p> Mail From : {!! $data['name'] !!}
<p>Title : {!! $data['title'] !!} </p>
<p>Ticket Number : {!! $data['ticket_number'] !!} </p>
<p>Description : {!! $data['description'] !!} </p>



Thanks,<br>

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. Super FOOTER!
@endcomponent
@endslot

{{ config('app.name') }}
@endcomponent
