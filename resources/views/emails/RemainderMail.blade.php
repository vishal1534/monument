@component('mail::message')
# Approval Needed Mail for Order #{{ $mailData['OrderId'] }}

Hi, {{ $mailData['title'] }}
{{ $mailData['message'] }}

@if($mailData['url'])

@component('mail::button', ['url' => $mailData['url']])
Click Here
@endcomponent

@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent
