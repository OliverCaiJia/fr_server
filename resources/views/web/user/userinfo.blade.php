<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="icon" href="">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('js/larea/LArea.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user/userinfo.css') }}">
    <title>水果贷-个人资料</title>
</head>

<body>
    <div class="container">
        <div class="main">
            <p class="tips">请填写真实有效信息,这将影响您的审核结果!</p>
            <div class="data-list">
                <div>
                    <div>
                        <label for="">居住所在地区：</label>
                        <input type="text" id="address" class="address" readonly placeholder="请选择">
                        <div class="arrow-right"> </div>
                    </div>
                </div>
                <div>
                    <div>
                        <label for="">居住详细地址：</label>
                        <input type="text" placeholder="街道、楼牌号"> </div>
                </div>
                <div>
                    <div>
                        <label for="">职业：</label> <i class="select-i">请选择</i>
                        <select name="" id="">
                            <option value="1">上班族</option>
                            <option value="2">公务员</option>
                            <option value="2">企业主</option>
                            <option value="3">自由职业</option>
                        </select>
                        <div class="arrow-right"> </div>
                    </div>
                </div>
                <div class='showData1'>
                    <div>
                        <label for="">公司名称：</label>
                        <input type="text" placeholder="请填写"> </div>
                </div>
                <div class='showData1'>
                    <div>
                        <label for="">公司所在地区：</label>
                        <input type="text" id="company-address" readonly placeholder="请选择" class="address">
                        <div class="arrow-right"> </div>
                    </div>
                </div>
                <div class='showData1'>
                    <div>
                        <label for="">公司详细地址：</label>
                        <input type="text" placeholder="请填写"> </div>
                </div>
                <div class='showData1'>
                    <div>
                        <label for="">月收入：</label> <i class="select-i">请选择</i>
                        <select name="" id="">
                            <option value="1">2千以下</option>
                            <option value="2">2千-5千</option>
                            <option value="3">5千-1万</option>
                            <option value="4">1万以上</option>
                        </select>
                        <div class="arrow-right"> </div>
                    </div>
                </div>
                <div class='showData3'>
                    <div>
                        <label for="">营业执照：</label> <i class="select-i">请选择</i>
                        <select name="" id="">
                            <option value="1">一年以内</option>
                            <option value="2">一年以上</option>
                        </select>
                        <div class="arrow-right"> </div>
                    </div>
                </div>
                <div>
                    <div>
                        <label for="">芝麻分：</label>
                        <input type="text" placeholder="请填写"> </div>
                </div>
                <div>
                    <div>
                        <label for="">公积金：</label> <i class="select-i">请选择</i>
                        <select name="" id="">
                            <option value="1">无公积金</option>
                            <option value="2">一年以下</option>
                            <option value="3">一年以上</option>
                        </select>
                        <div class="arrow-right"> </div>
                    </div>
                </div>
                <div>
                    <div>
                        <label for="">社保：</label>
                        <p class="radio-box"><span>有</span><span>无</span></p>
                    </div>
                </div>
                <div>
                    <div>
                        <label for="">名下房产：</label>
                        <p class="radio-box"><span>有</span><span>无</span></p>
                    </div>
                </div>
                <div>
                    <div>
                        <label for="">名下汽车：</label>
                        <p class="radio-box"><span>有</span><span>无</span></p>
                    </div>
                </div>
                <div>
                    <div>
                        <label for="">寿险保单：</label>
                        <p class="radio-box"><span>有</span><span>无</span></p>
                    </div>
                </div>
                <div>
                    <div>
                        <label for="">微粒贷：</label>
                        <p class="radio-box"><span>有</span><span>无</span></p>
                    </div>
                </div>
            </div>
            <div class="button">立即绑定</div>
        </div>
    </div>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/larea/LAreaData1.js') }}"></script>
    <script src="{{ asset('js/larea/LArea.js') }}"></script>
    <script>
        var userinfoController = {
            init: function() {
                this.areaSelect('#address');
                this.areaSelect('#company-address');
                this.selectChange();
                this.radioView();
            },
            /*地址选择*/
            areaSelect: function(dom) {
                var _this = this;
                var area1 = new LArea();
                area1.init({
                    'trigger': dom,
                    'keys': {
                        id: 'id',
                        name: 'name'
                    },
                    'type': 1,
                    'data': LAreaData
                });
                area1.value = [1, 13, 3];
                $(dom).focus(function() {
                    document.activeElement.blur();
                });
            },
            selectChange: function() {
                $('select').on('change', function() {
                    var text = $(this).find("option:selected").text();
                    var val = $(this).find("option:selected").val();
                    $(this).prev('i').text(text).addClass('selectColor');
                    $('.showData1,.showData3').hide();
                    console.log(text)
                    if (text == '上班族' || text == '公务员') {
                        $('.showData1').show();
                    } else if (text == '企业主') {
                        $('.showData3').show();
                    }
                })
            }, //单选点击
            radioView: function() {
                $('.radio-box').on('click', 'span', function() {
                    $(this).addClass('active').siblings('span').removeClass('active');
                })
            }, //提交成功后终端交互
            personInfoBind: function() {
                try {
                    window.sd.personInfoBind();
                    return;
                } catch (e) {
                    console.log("Android-提交信息方法失败");
                }
                try {
                    window.webkit.messageHandlers.personInfoBind.postMessage({});
                    return;
                } catch (e) {
                    console.log("ios-提交信息方法失败");
                }
                try {
                    window.parent.postMessage({
                        'type': 'personInfo'
                    }, '*');
                    return;
                } catch (e) {
                    console.log("h5-提交信息方法返失败");
                }
            }
        }
        $(function() {
            userinfoController.init();
        })

    </script>
</body>

</html>
