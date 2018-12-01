<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="icon" href="">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/invite/invite.css') }}">
    <title>水果贷-分享</title>
</head>

<body>
    <div class="main">
        <section>
            <p><i><img src="/img/invite/invite_number_one.png" alt=""></i><span>活动时间：永久有效</span></p>
            <p><i><img src="/img/invite/invite_number_two.png" alt=""></i><span>活动期间每邀请一位好友成功付费申请，您将获得奖励金36元</span></p>
            <p><i><img src="/img/invite/invite_number_three.png" alt=""></i><span>举个例子:您每天成功邀请10人,您将获得360元,一个月您将有10800元业余收入</span></p>
        </section>
        <section>
            <p>满100元可随时取现</p> <a onclick="withdrawView()">立即提现</a> </section>
        <section>
            <p> <span>分享链接给好友</span> <span>好友成功付费</span> <span>提取奖金</span> </p>
        </section>
        <section> <img src="/img/invite/invite_bg4_title.png" alt="">
            <ul>
                <li> <span>账号</span> <span>奖项</span> <span>奖金</span> </li> @foreach($data as $item)
                <li> <span>{{ $item['mobile'] }}</span> <span>付费</span> <span>+36</span> </li> @endforeach
                <li> <span>合计</span> <span>--</span> <span>+{{ $count }}</span> </li>
            </ul>
        </section>
        <p class="btn" onclick='inviteView()'>立即邀请</p>
    </div>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script>
        function withdrawView() {
            try {
                window.sd.withdraw();
                return;
            } catch (e) {
                console.log("Android-立即提现方法失败");
            }
            try {
                window.webkit.messageHandlers.withdraw.postMessage({});
                return;
            } catch (e) {
                console.log("ios-立即提现方法失败");
            }
            try {
                window.parent.postMessage({
                    'type': 'withdraw'
                }, '*');
                return;
            } catch (e) {
                console.log("h5-立即提现方法返失败");
            }
        }

        function inviteView() {
            try {
                window.sd.inviteFriend();
                return;
            } catch (e) {
                console.log("Android-立即邀请方法失败");
            }
            try {
                window.webkit.messageHandlers.inviteFriend.postMessage({});
                return;
            } catch (e) {
                console.log("ios-立即邀请方法失败");
            }
            try {
                window.parent.postMessage({
                    'type': 'inviteFriend'
                }, '*');
                return;
            } catch (e) {
                console.log("h5-立即邀请方法返失败");
            }
        }

    </script>
</body>

</html>
