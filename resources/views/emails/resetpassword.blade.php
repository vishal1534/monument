@component('mail::message')
# Password Reset Mail for Account {{ $params['email'] }}

Hi, {{ $params['name'] }} <br>
You are receiving this email because we received a password reset request for your account.

Reset your password on the following link.
@component('mail::button', ['url' => $params['redirect_link']])
    Click Here
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
