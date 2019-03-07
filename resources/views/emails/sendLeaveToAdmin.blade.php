@component('mail::message')

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
<p>From : {!! $data['from'] !!} </p>
<p>To : {!! $data['to'] !!} </p>
<p>TotalDays : {!! $data['total_days'] !!} </p>
<p>Reason : {!! $data['reason'] !!} </p>


<div class="row" style="display:inline-flex !important;">
	<div class="col-md-6">
@component('mail::button', ['url' => route('approve-leave',$data['id']),'color' => 'primary' ])
Approved
@endcomponent
</div>
	<div class="col-md-6">

@component('mail::button',['url' => route('denied-leave',$data['id']), 'color' => 'error'])
Denied
@endcomponent
</div></div>

Thanks,<br>

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. Super FOOTER!
@endcomponent
@endslot

{{ config('app.name') }}
@endcomponent

