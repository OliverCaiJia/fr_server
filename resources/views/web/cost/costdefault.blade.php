<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="icon" href="">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cost/costDefault.css') }}">
    <title>水果贷-推荐服务</title>
</head>

<body>
    <div class="container">
        <div class="main">
            <div class="banner"> <img src="/img/cost/banner.png" alt=""> </div>
            <div class="recommend-list">
                <h3 class="title">为您推荐：</h3>
                <div class="service-list">
                    <dl> <dt><img src="/img/cost/icon_recommend.png" alt=""></dt>
                        <dd>
                            <h4>借款{{ $data['groom']['amount'] }}元/{{ $data['groom']['peroid'] }}</h4>
                            <p>{{ $data['groom']['remark'] }}
                                <br><span>￥<i>{{ $data['groom']['price'] }}</i></span><del>￥<i class="recommendPrice">{{ $data['groom']['old_price'] }}</i></del></p>
                        </dd> <span class="selectIconShow"></span> </dl>
                </div>
            </div>
            <div class="give-list">
                <h3 class="title">您买我就送：</h3> @foreach( $data['time_limit'] as $item)
                <div class="service-list give-service-list" data-seqnid="{{ $item['seq_nid'] }}">
                    <dl> <dt><img src="/img/cost/icon_give.png" alt=""></dt>
                        <dd>
                            <h4>{{ $item['name'] }}</h4>
                            <p>{{ $item['remark'] }}
                                <br><span>￥<i>{{ $item['price'] }}</i></span><del>￥<i class="givePrice">{{ $item['old_price'] }}</i></del></p>
                        </dd> <span class='selectIcon'></span> </dl>
                </div> @endforeach </div>
        </div>
        <footer>
            <div class="left">
                <h3>总计：<span>￥<i id="totalPrice">{{ $data['groom']['price'] }}</i></span></h3>
                <p><del>原价:￥<i class="originalPrice"></i></del></p>
            </div>
            <div class="right" id='submit'> 付款 </div>
        </footer>
        <div class="token" style="display: none">{{ $token }}</div>
    </div>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/base.js') }}"></script>
    <script src="{{ asset('js/sha1.min.js') }}"></script>
    <script src="{{ asset('js/api.js') }}"></script>
    <script src="{{ asset('js/cost/costdefault.js') }}"></script>
</body>

</html>
