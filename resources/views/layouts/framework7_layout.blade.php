{{--/**--}}
 {{--* Created by PhpStorm.--}}
 {{--* User: imokhles--}}
 {{--* Date: 2019-02-26--}}
 {{--* Time: 11:44--}}
 {{--*/--}}
        <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <!-- Color theme for statusbar -->
    <meta name="theme-color" content="#2196f3">
    <!-- Your app title -->
    <title>{{config('app.name')}}</title>
    @yield('before_styles')
    <!-- Path to Framework7 Library Bundle CSS -->
    <link rel="stylesheet" href="{{asset('framework7/css')}}/framework7.bundle.min.css">
    <link rel="stylesheet" href="{{asset('framework7/css')}}/framework7-icons.css">
    <link rel="stylesheet" href="{{asset('css')}}/imrepo_app.css">
    <link rel="stylesheet" href="{{asset('css')}}/font-awesome.min.css">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

    @yield('after_styles')
</head>
<body>


<!-- App root element -->
<div id="app">
    <!-- Statusbar overlay -->
    <div class="statusbar"></div>
    <!-- Your main view, should have "view-main" class -->
    <div class="view view-main">
        @yield('content')
    </div>
</div>

@yield('before_scripts')
<!-- Path to Framework7 Library Bundle JS-->
<script type="text/javascript" src="{{asset('framework7/js')}}/framework7.bundle.min.js"></script>
<script type="text/javascript" src="{{asset('js')}}/imrepo_app.js"></script>

@yield('after_scripts')
</body>
</html>