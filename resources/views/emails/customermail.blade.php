@component('mail::message')
 
@if(isset($param["order"]))
# Customer View Mail for Order #{{ $params['order'] }}
@else
# Customer View Mail for Work Order #{{ $params['work_order_id'] }}
@endif

Hi, {{ $params['name'] }} <br>
{{ $params['message'] }}

@if($params['link'])
View Uploaded Image on the following link.
@component('mail::button', ['url' => $params['redirect_link']])
    Click Here
@endcomponent
@endif


Thanks,<br>
{{ config('app.name') }}
@endcomponent
