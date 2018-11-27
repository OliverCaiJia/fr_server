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
                        <input type="text" id="address" class="address" readonly placeholder="请选择" value="{{isset($data['user_location']) ? $data['user_location'] : ''}}">
                        <div class="arrow-right"> </div>
                    </div>
                </div>
                <div>
                    <div>
                        <label for="">居住详细地址：</label>
                        <input type="text" placeholder="街道、楼牌号" value="{{isset($data['user_address']) ? $data['user_address'] : ''}}" id='user_address'> </div>
                </div>
                <div>
                    <div>
                        <label for="">职业：</label> <i class="select-i">{{isset($data['profession']) ? $data['profession'] : '请选择'}}</i>
                        <select name="" id="profession">
                            <option value="" disabled>请选择</option>
                            <option value="0">上班族</option>
                            <option value="1">公务员</option>
                            <option value="2">企业主</option>
                            <option value="3">自由职业</option>
                        </select>
                        <div class="arrow-right"> </div>
                    </div>
                </div>
                <div class='showData4'>
                    <div>
                        <label for="">公司名称：</label>
                        <input type="text" placeholder="请填写" value="{{isset($data['company_name']) ? $data['company_name'] : ''}}" id='company_name'> </div>
                </div>
                <div class='showData4'>
                    <div>
                        <label for="">公司所在地区：</label>
                        <input type="text" id="company_location" readonly placeholder="请选择" class="address" value="{{isset($data['company_location']) ? $data['company_location'] : ''}}">
                        <div class="arrow-right"> </div>
                    </div>
                </div>
                <div class='showData4'>
                    <div>
                        <label for="">公司详细地址：</label>
                        <input type="text" placeholder="请填写" value="{{isset($data['company_address']) ? $data['company_address'] : ''}}" id='company_address'> </div>
                </div>
                <div class='showData1'>
                    <div>
                        <label for="">工作时间：</label> <i class="select-i">{{isset($data['work_time']) ? $data['work_time'] : '请选择'}}</i>
                        <select name="" id="work_time">
                            <option value="" disabled>请选择</option>
                            <option value="0">半年内</option>
                            <option value="1">一年以内</option>
                            <option value="2">一年以上</option>
                        </select>
                        <div class="arrow-right"> </div>
                    </div>
                </div>
                <div class='showData1'>
                    <div>
                        <label for="">月收入：</label> <i class="select-i">{{isset($data['month_salary']) ? $data['month_salary'] : '请选择'}}</i>
                        <select name="" id="month_salary">
                            <option value="" disabled>请选择</option>
                            <option value="0">2千以下</option>
                            <option value="1">2千-5千</option>
                            <option value="2">5千-1万</option>
                            <option value="3">1万以上</option>
                        </select>
                        <div class="arrow-right"> </div>
                    </div>
                </div>
                <div class='showData3'>
                    <div>
                        <label for="">营业执照：</label> <i class="select-i">请选择</i>
                        <select name="" id="company_license_time">
                            <option value="" disabled>请选择</option>
                            <option value="0">一年以内</option>
                            <option value="1">一年以上</option>
                        </select>
                        <div class="arrow-right"> </div>
                    </div>
                </div>
                <div>
                    <div>
                        <label for="">芝麻分：</label>
                        <input type="number" placeholder="请填写" value="{{isset($data['zhima_score']) ? $data['zhima_score'] : ''}}" id='zhima_score'> </div>
                </div>
                <div>
                    <div>
                        <label for="">公积金：</label> <i class="select-i">{{isset($data['house_fund_time']) ? $data['house_fund_time'] : '请选择'}}</i>
                        <select name="" id="house_fund_time">
                            <option value="" disabled>请选择</option>
                            <option value="0">无公积金</option>
                            <option value="1">一年以下</option>
                            <option value="2">一年以上</option>
                        </select>
                        <div class="arrow-right"> </div>
                    </div>
                </div>
                <div>
                    <div>
                        <label for="">社保：</label>
                        <p class="radio-box" id='has_social_security'> <span @if(isset($data[ 'has_social_security']) && $data[ 'has_social_security']==1 ) class="active" @endif data-val='0'>有</span> <span @if(isset($data[ 'has_social_security']) && $data[ 'has_social_security']==0 ) class="active" @endif data-val='1'>无</span> </p>
                    </div>
                </div>
                <div>
                    <div>
                        <label for="">名下房产：</label>
                        <p class="radio-box" id='has_house'> <span @if(isset($data[ 'has_house']) && $data[ 'has_house']==1 ) class="active" @endif data-val='0'>有</span> <span @if(isset($data[ 'has_house']) && $data[ 'has_house']==0 ) class="active" @endif data-val='1'>无</span> </p>
                    </div>
                </div>
                <div>
                    <div>
                        <label for="">名下汽车：</label>
                        <p class="radio-box" id='has_auto'> <span @if(isset($data[ 'has_auto']) && $data[ 'has_auto']==1 ) class="active" @endif data-val='0'>有</span> <span @if(isset($data[ 'has_auto']) && $data[ 'has_auto']==0 ) class="active" @endif data-val='1'>无</span> </p>
                    </div>
                </div>
                <div>
                    <div>
                        <label for="">寿险保单：</label>
                        <p class="radio-box" id='has_assurance'> <span @if(isset($data[ 'has_assurance']) && $data[ 'has_assurance']==1 ) class="active" @endif data-val='0'>有</span> <span @if(isset($data[ 'has_assurance']) && $data[ 'has_assurance']==0 ) class="active" @endif data-val='1'>无</span> </p>
                    </div>
                </div>
                <div>
                    <div>
                        <label for="">信用卡：</label>
                        <p class="radio-box" id='has_creditcard'> <span @if(isset($data[ 'has_creditcard']) && $data[ 'has_creditcard']==1 ) class="active" @endif data-val='0'>有</span> <span @if(isset($data[ 'has_creditcard']) && $data[ 'has_creditcard']==0 ) class="active" @endif data-val='1'>无</span> </p>
                    </div>
                </div>
                <div>
                    <div>
                        <label for="">微粒贷：</label>
                        <p class="radio-box" id='has_weilidai'> <span @if(isset($data[ 'has_weilidai']) && $data[ 'has_weilidai']==1 ) class="active" @endif data-val='0'>有</span> <span @if(isset($data[ 'has_weilidai']) && $data[ 'has_weilidai']==0 ) class="active" @endif data-val='1'>无</span> </p>
                    </div>
                </div>
            </div>
            <div class="button">立即绑定</div>
            <div class="token" style="display: none">{{ $token }}</div>
        </div>
    </div>
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/base.js') }}"></script>
    <script src="{{ asset('js/sha1.min.js') }}"></script>
    <script src="{{ asset('js/larea/LAreaData1.js') }}"></script>
    <script src="{{ asset('js/larea/LArea.js') }}"></script>
    <script src="{{ asset('js/api.js') }}"></script>
    <script src="{{ asset('js/user/userinfo.js') }}"></script>
</body>

</html>
