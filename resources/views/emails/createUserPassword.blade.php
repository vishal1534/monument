@component('mail::message')
# {{ $params['subject'] }} {{  $params['email'] }}

Hi, {{ $params['name'] }} <br>
You are receiving this email because we received a {{ $params['title']  }} request for your account.

{{ $params['title']  }} on the following link.
@component('mail::button', ['url' => $params['redirect_link']])
 Click Here
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
