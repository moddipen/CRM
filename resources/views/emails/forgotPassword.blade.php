@component('mail::message')

{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
Header Title
@endcomponent
@endslot



<p> Hello,Please Click On the Reset Password Button To Reset Password </p>

@component('mail::button', ['url' => route('reset.password',$data['id']),'color' => 'primary' ])
Reset Password
@endcomponent

Thanks,<br>

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. Super FOOTER!
@endcomponent
@endslot

{{ config('app.name') }}
@endcomponent

