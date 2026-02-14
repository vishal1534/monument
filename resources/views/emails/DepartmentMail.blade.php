@component('mail::message')
# Task Creation Mail for Order #{{ $params['order'] }}

Hi, {{ $params['name'] }} <br>
{{ $params['message'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
