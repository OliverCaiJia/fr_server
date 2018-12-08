<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>水果金服 - 登录</title>
    <meta name="keywords" content="水果金服">
    <meta name="description" content="水果金服">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link href="{{ asset('vendor/hui/css/bootstrap.min14ed.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/hui/css/font-awesome.min93e3.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/hui/css/style.min862f.css') }}" rel="stylesheet">
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html"/>
    <![endif]-->
    <script>if (window.top !== window.self) {
            window.top.location = window.location;
        }</script>
</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <div>
            <h1 class="logo-name">L+</h1>
        </div>
        <h3>欢迎使用</h3>
        <form class="m-t" role="form" method="post" action="{{ route('admin.login') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="用户名" value="{{ old('username') }}" required="">
                @if ($errors->has('username'))
                    <span class="help-block">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="密码" required="">
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <button type="submit" class="btn btn-success block full-width m-b">登 录</button>
        </form>
    </div>
</div>
<script src="{{ asset('vendor/hui/js/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/hui/js/bootstrap.min.js') }}"></script>
</body>
</html>
