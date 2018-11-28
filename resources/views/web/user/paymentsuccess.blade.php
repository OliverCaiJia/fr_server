<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="icon" href="">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <title>水果贷-支付结果</title>
    <style>
        html,
        body,
        .container {
            width: 100%;
            height: 100%;
        }

        .container {
            position: relative;
        }

        .success,
        .error {
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: -50%;
            margin-left: -50%;
        }

        img {
            width: 5rem;
            margin: 0 auto;
            display: block;
        }

        p {
            font-size: .32rem;
            color: #333;
            text-align: center;
        }

        p a {
            color: #4c86f5;
        }

    </style>
</head>

<body>
    <div class="container">
        <div class="success"> <img src="/img/user/pay_success.png" alt="">
            <p>支付成功！<a onclick="payController.paymentResult('success')">立即跳转</a></p>
        </div>
        <div class="error"> <img src="/img/user/pay_success.png" alt="">
            <p>支付成功！<a onclick="payController.paymentResult('error')">立即跳转</a></p>
        </div>
    </div>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script>
        var payController = {
            //立即跳转-支付
            paymentResult: function(payResult) {
                try {
                    window.sd.paymentResult(payResult);
                    return;
                } catch (e) {
                    console.log("Android-点击协议方法失败");
                }
                try {
                    window.webkit.messageHandlers.paymentResult.postMessage({
                        payResult: payResult
                    });
                    return;
                } catch (e) {
                    console.log("ios-点击协议方法失败");
                }
                try {
                    window.parent.postMessage({
                        'type': 'paymentResult',
                        'payResult': payResult
                    }, '*');
                    return;
                } catch (e) {
                    console.log("h5-点击协议方法返失败");
                }
            }
        }

    </script>
</body>

</html>
