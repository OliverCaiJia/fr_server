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
                    <dl> <dt><img src="" alt=""></dt>
                        <dd>
                            <h4>{{ $data['groom']['name'] }}</h4>
                            <p>{{ $data['groom']['remark'] }}
                                <br><span>￥<i>{{ $data['groom']['price'] }}</i></span>￥{{ $data['groom']['old_price'] }}</p>
                        </dd> <span></span> </dl>
                </div>
            </div>
            <div class="give-list">
                <h3 class="title">您买我就送：</h3>
                @foreach( $data['time_limit'] as $item)
                    <div class="service-list">
                        <dl> <dt><img src="" alt=""></dt>
                            <dd>
                                <h4>{{ $item['name'] }}</h4>
                                <p>{{ $item['remark'] }}
                                    <br><span>￥<i>{{ $item['price'] }}</i></span>￥{{ $item['old_price'] }}</p>
                            </dd> <span class='selectIcon'></span> </dl>
                    </div>
                @endforeach
            </div>
        </div>
        <footer>
            <div class="left">
                <h3>总计：<span>￥<i>{{ $data['groom']['price'] }}</i></span></h3>
                <p>原价:￥378</p>
            </div>
            <div class="right"> 付款 </div>
        </footer>
    </div>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script>
        var costdefatltController = {
            init: function() {
                this.selectView()
            }, //选择赠送协议
            selectView: function() {
                var _self = this;
                $('.service-list').on('click', function() {
                    $(this).siblings('div').find('.selectIcon').hide();
                    $(this).find('.selectIcon').show();
                    _self.recommendService();
                })
            }, //选择赠送协议交互
            recommendService: function() {
                try {
                    window.sd.recommendService();
                    return;
                } catch (e) {
                    console.log("Android-选择赠送协议方法失败");
                }
                try {
                    window.webkit.messageHandlers.recommendService.postMessage({});
                    return;
                } catch (e) {
                    console.log("ios-选择赠送协议方法失败");
                }
                try {
                    window.parent.postMessage({
                        'type': 'recommendService'
                    }, '*');
                    return;
                } catch (e) {
                    console.log("h5-选择赠送协议方法返失败");
                }
            }
        }
        $(function() {
            costdefatltController.init();
        })

    </script>
</body>

</html>