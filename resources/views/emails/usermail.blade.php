@component('mail::message')
Login Details
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
Login Details
@endcomponent
@endslot

<p> Hello Your Login Details, </p>

<p> Email : {!! $data['email'] !!} </p>
<p> Password : {!! $data['password'] !!} </p><br>

@component('mail::button', ['url' => route('admin.login'),'color' => 'primary' ])
Click Here To Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
