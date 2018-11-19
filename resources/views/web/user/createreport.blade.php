<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="icon" href="">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <title>水果贷-信用评估</title>
    <style>
        html,
        body {
            width: 100%;
            height: 100%;
        }

        .container {
            width: 100%;
            height: 10.86rem;
            background: url('/img/user/create_bg.png') no-repeat;
            background-size: 100%;
            font-size: .24rem;
            color: #fff;
            position: relative;
        }

        .agreement {
            position: absolute;
            bottom: .3rem;
            left: .3rem;
        }

        span {
            color: #FEDD7C;
        }

        .service {
            width: 1.2rem;
            position: absolute;
            right: .06rem;
            bottom: .6rem;
            text-align: center;
        }

        .service img {
            display: block;
            width: .8rem;
            height: .8rem;
            margin: 0 auto .1rem;
        }

    </style>
</head>

<body>
    <div class="container">
        <p class="agreement">申请即同意<span>《信用评估服务协议》</span></p>
        <div class="service"> <img src="/img/user/kefu_icon.png" alt="">
            <p>在线客服</p>
        </div>
    </div>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
</body>

</html>
