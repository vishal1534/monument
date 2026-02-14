@component('mail::message',['imgUrl'=>$imgUrl])
# Approval Needed Mail for Order #{{ $params['order'] }}

Hi {{ $params['name'] }}, <br>
{{ $params['message'] }}

@if($params['link'] && isset($params['mps_collaboration_link']))
View Approval Needed File on the following link.
@component('mail::button', ['url' => $params['mps_collaboration_link']])
    Click Here
@endcomponent
@endif
@if($imgUrl)
<img data-x-id="imgUrl" class="img-responsive" data-x-src="{{ config('app.url').'/'.$imgUrl }}" src="{{ config('app.url').'/'.$imgUrl }}" alt="{{ config('app.name') }}" style="width: 100%; height: 100%;">
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent

