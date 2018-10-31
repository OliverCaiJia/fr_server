<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>{{$saas_global_name}}@yield('title', config('app.name', 'Laravel'))</title>
    <meta name="keywords" content="{{ config('app.name', 'Laravel') }}">
    <meta name="description" content="{{ config('app.name', 'Laravel') }}">

    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link href="{{ asset('vendor/hui/css/bootstrap.min14ed.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/hui/css/font-awesome.min93e3.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/hui/css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/hui/css/style.min.css') }}" rel="stylesheet">
    @yield('css')
</head>

<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    @yield('content')
</div>
<script src="{{ asset('vendor/hui/js/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/hui/js/bootstrap.min.js') }}"></script>
@yield('js')
</body>
</html>
