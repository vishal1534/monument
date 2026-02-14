<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MPS - @yield('title')</title>
    {{-- <!-- Tell the browser to be responsive to screen width --> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    {{-- <!-- Google Font: Source Sans Pro --> --}}
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    {{-- <!-- Font Awesome --> --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    {{-- <!-- Custom Css --> --}}
    <script src="{{ mix('/js/app.js') }}" defer></script>
    <script src="{{ mix('/js/vendor.js') }}" defer></script>
    <script src="{{ mix('/js/manifest.js') }}" defer></script>
    <link href="{{ mix('/css/app.css')}}" rel="stylesheet">
    <base href="{{ env('APP_URL') }}" />
</head>
<body>
<div class="remove-div-width-for-mobile" id="remove-width-style">
    <div id="app">

    </div>
</div>

</body>
</html>
<style>
    .remove-div-width-for-mobile{
        min-width:1300px !important;
    }
</style>
