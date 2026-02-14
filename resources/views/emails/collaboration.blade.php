@component('mail::message')
# Collaboration Mail for Order #{{ $params['order'] }}

Hi, {{ $params['name'] }} <br>
{{ $params['message'] }}

@if($params['link'])
Upload your files on the following link.
@component('mail::button', ['url' => $params['redirect_link']])
    Click Here
@endcomponent
@endif


Thanks,<br>
{{ config('app.name') }}
@endcomponent
