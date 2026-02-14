@component('mail::message')
# {{ $params['message_one'] }} for Order #{{ $params['order'] }}

Hi {{ $params['name'] }}, <br>
{{ $params['message']  }}


View {{ $params['message_two']  }} on following link.
@component('mail::button', ['url' => $params['mps_collaboration_link']])
        Click Here
@endcomponent

Thanks,<br>
Frisbie Monument
@endcomponent
