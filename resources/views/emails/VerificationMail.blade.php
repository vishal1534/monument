@component('mail::message')
# Verification Mail for Account {{ $params['email'] }}

Hi, {{ $params['name'] }} <br>
You are receiving this email because you have created an account.

Please confirm your identity on the following link.
@component('mail::button', ['url' => $params['redirect_link']])
    Click Here
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
