@extends('layouts.layout')
@section('content')
    <style>
        h5  {
            font-size: 16px;
            color:#1ab394;
            font-weight:650;
        }

        .status {
            top: 1px;
            transform-origin: 68.5px 8.5px 0px;
            color: #ffffff;
            height: 19px;
            background: inherit;
            background-color: #1ab394;
            border: none;
            border-radius: 5px;
            -moz-box-shadow: none;
            -webkit-box-shadow: none;
            box-shadow: none;
            padding: 0px 8px;
        }
        .trbg {
            background-color:#f5f5f5;
        }
    </style>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox-title">
                <h5>详情</h5>
            </div>
            <div class="ibox-content">
                <div class="col-sm-3">
                    <a class="menuid btn btn-primary btn-sm" href="URL::previous()">返回</a>
                </div>
                <div class="row">
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#tab-1" aria-expanded="true">
                            反欺诈
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#tab-2" aria-expanded="false">
                            申请准入
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#tab-4" aria-expanded="false">
                            (额度评估)账户
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#tab-4" aria-expanded="false">
                            (额度评估)电商
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#tab-5" aria-expanded="false">
                            贷后行为
                        </a>
                    </li>
                    <li>
                        <a href="#multilateral-lending" role="tab" data-toggle="tab">
                            黑灰名单
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#tab-6" aria-expanded="false">
                            多头
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            111
                            <table class="table table-condensed table-hover" width="100%">
                                <tbody>
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <h5>基本信息</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">姓名：</label></td>
                                    <td>111
                                        <span class="status">已三要素实名认证</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">身份证号：</label></td>
                                    <td>
                                        111
                                        <span class="status">已三要素实名认证</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">手机号：</label></td>
                                    <td>111
                                        <span class="status">运营商已认证</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">芝麻分：</label></td>
                                    <td>
                                            <span class="zhima">111</span>
                                            <span class="status">芝麻分已认证</span>

                                    </td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">微信号：</label></td>
                                    <td>111</td>
                                </tr>

                                <tr>
                                    <td><label class="control-label"> 紧急联系人：</label></td>
                                    <td>111</td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">姓名：</label></td>
                                    <td>111</td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">手机号：</label></td>
                                    <td>111</td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">月收入：</label></td>
                                    <td>111</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <h5>户籍信息</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">年龄：</label></td>
                                    <td>111</td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">性别：</label></td>
                                    <td>111</td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">户籍地址：</label></td>
                                    <td>111</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <h5>贷款信息</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">渠道：</label></td>
                                    <td>111</td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">申请金额：</label></td>
                                    <td>111</td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">周期：</label></td>
                                    <td>111</td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">还款方式：</label></td>
                                    <td>
                                        111
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="tab-2" class="tab-pane">
                        <div class="panel-body">
                                <table class="table table-condensed table-hover" width="100%">
                                    111
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>基本信息</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">手机号：</label></td>
                                        <td>111</td>
                                        <td><label class="control-label">姓名：</label></td>
                                        <td>111</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">证件号：</label></td>
                                        <td><label class="control-label">111</label></td>
                                        <td><label class="control-label">报告获取时间：</label></td>
                                        <td>111</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label"> 运营商：</label></td>
                                        <td>111</td>
                                        <td><label class="control-label">帐号状态：</label></td>
                                        <td>1-单向停机</td>
                                    <tr>
                                        <td><label class="control-label">开户时间：</label></td>
                                        <td>111</td>
                                        <td><label class="control-label">开户时长：</label></td>
                                        <td>111</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">用户邮箱：</label></td>
                                        <td>111</td>
                                        <td><label class="control-label">用户地址：</label></td>
                                        <td>111</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">手机号归属地：</label></td>
                                        <td>111</td>
                                        <td><label class="control-label">居住地址：</label></td>
                                        <td>111</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">余额：</label></td>
                                        <td>1111</td>
                                        <td><label class="control-label">套餐：</label></td>
                                        <td>111</td>
                                    </tr>
                                    </tbody>
                                </table>
                                基本信息校验
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    111
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <h5>基本信息校验</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">名称</td>
                                        <td colspan="2">结果</td>
                                    </tr>
                                    <tr>
                                    <td colspan="2">身份证有效性</td>
                                    <td colspan="2"> basicCheck['idcard_check']['result'] </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">邮箱有效性</td>
                                        <td colspan="2">111</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">地址有效性</td>
                                        <td colspan="2">111</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">通过话记录完整性</td>
                                        <td colspan="2">111</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">身份证号码是否与运营商数据匹配</td>
                                        <td colspan="2">111</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">姓名是否与运营商数据匹配</td>
                                        <td colspan="2">111</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">申请人姓名+身份证号码是否出现在法院黑名单</td>
                                        <td colspan="2">111</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">申请人姓名+身份证号码是否出现在金融机构黑名单</td>
                                        <td colspan="2">111</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">申请人姓名+手机号码是否出现在金融机构黑名单</td>
                                        <td colspan="2">111</td>
                                    </tr>
                                    </tbody>
                                </table>
                                联系人信息核对
                                111
                                    <table class="table table-condensed table-hover" width="100%">
                                        <tbody>
                                        <tr>
                                            <td colspan="12" class="text-center">
                                                <h5>联系人信息核对</h5>
                                            </td>
                                        </tr>
                                            <tr>
                                                <td><label class="control-label">姓名：</label></td>
                                                <td>111</td>
                                                <td><label class="control-label">与申请人关系：</label></td>
                                                <td>111</td>
                                                <td><label class="control-label">手机号：</label></td>
                                                <td>111</td>
                                                <td>111</td>
                                                <td><label class="control-label">与该联系人通话记录：</label></td>
                                                <td>111</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                指定联系人联系情况
                                111
                                    <table class="table table-condensed table-hover" width="100%">
                                        <tbody>
                                        <tr>
                                            <td colspan="12" class="text-center">
                                                <h5>指定联系人联系情况</h5>
                                            </td>
                                        <tr>
                                            <td>序号</td>
                                            <td>联系人号码</td>
                                            <td>姓名</td>
                                            <td>关系</td>
                                            <td>归属地</td>
                                            <td>通话次数</td>
                                            <td>通话时长</td>
                                            <td>第一次通话</td>
                                            <td>最后一次通话</td>
                                            <td>短信次数</td>
                                        </tr>
                                            <tr>
                                                <td>1111</td>
                                                <td>111</td>
                                                <td>111</td>
                                                <td>111</td>
                                                <td>111</td>
                                                <td>111</td>
                                                <td>111</td>
                                                <td>111</td>
                                                <td>111</td>
                                                <td>111</td>
                                            </tr>
                                            </tr>
                                        </tbody>
                                    </table>
                                用户信息检测
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <h5>用户信息监测</h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>直接联系人中黑名单人数：</td>
                                            <td>111</td>
                                        </tr>
                                        <tr>
                                            <td>间接联系人中黑名单人数：</td>
                                            <td>111</td>
                                        </tr>
                                        <tr>
                                            <td>直接联系人人数：</td>
                                            <td>111</td>
                                        </tr>
                                        <tr>
                                            <td>引起间接黑名单人数：</td>
                                            <td>111</td>
                                        </tr>
                                        <tr>
                                            <td>直接联系人中引起间接黑名单占比：</td>
                                            <td>111</td>
                                        </tr>
                                        <tr>
                                            <td>查询过该用户的相关企业类型（姓名+身份证号+电话号码）：</td>
                                            <td>
                                                111
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>身份证组合过的其他姓名：</td>
                                            <td>
                                                111
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>身份证组合过的其他电话：</td>
                                            <td>
                                                111
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>电话号码组合过其他姓名：</td>
                                            <td>
                                                111
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>电话号码组合过其他身份证：</td>
                                            <td>
                                                111
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>电话号码注册过相关的企业数量：</td>
                                            <td>111</td>
                                        </tr>
                                        <tr>
                                            <td>电话号码注册过相关的企业类型：</td>
                                            <td>
                                                111
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>电话号码出现过的公开信息网站：</td>
                                            <td>
                                                111
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                行为分析
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    111
                                        <tr>
                                            <td colspan="12" class="text-center">
                                                <h5>行为分析</h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>月份</td>
                                            <td>消费金额(分)</td>
                                            <td>流量使用</td>
                                            <td>短信</td>
                                            <td>通话次数</td>
                                            <td>通话时长(秒)</td>
                                            <td>主叫次数</td>
                                            <td>主叫时长(秒)</td>
                                            <td>被叫次数</td>
                                            <td>被叫时长(秒)</td>
                                        </tr>
                                            <tr>
                                                <td>111</td>
                                                <td>111</td>
                                                <td>111</td>
                                                <td>111</td>
                                                <td>111</td>
                                                <td>111</td>
                                                <td>111</td>
                                                <td>111</td>
                                                <td>111</td>
                                                <td>111</td>
                                            </tr>
                                    </tbody>
                                </table>
                                充值记录
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    111
                                        <tr>
                                            <td colspan="12" class="text-center">
                                                <h5>充值记录</h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>月份</td>
                                            <td>充值次数</td>
                                            <td>充值金额(元)</td>
                                        </tr>
                                            <tr>
                                                <td>1111</td>
                                                <td>111</td>
                                                <td>111</td>
                                            </tr>
                                        <tr>
                                            <td>合计</td>
                                            <td>111</td>
                                            <td>111</td>
                                        </tr>
                                    </tbody>
                                </table>
                                行为检测
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    111
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>行为检测</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>分析点</td>
                                        <td>结果</td>
                                        <td>说明</td>
                                    </tr>
                                    <tr>
                                        <td>朋友圈</td>
                                        <td>111</td>
                                        <td>111</td>
                                    </tr>
                                    <tr>
                                        <td>号码使用时间</td>
                                        <td>111</td>
                                        <td>1111</td>
                                    </tr>
                                    <tr>
                                        <td>手机静默情况</td>
                                        <td>111</td>
                                        <td>111</td>
                                    </tr>
                                    <tr>
                                        <td>静默度</td>
                                        <td>111</td>
                                        <td>180天内无通话记录的时间占比</td>
                                    </tr>
                                    <tr>
                                    <td>关机情况</td>
                                    <td> behaviorCheck['phone_power_off']['result'] </td>
                                    <td> behaviorCheck['phone_power_off']['evidence'] </td>
                                    </tr>
                                    <tr>
                                        <td>互通电话的号码数量</td>
                                        <td>111</td>
                                        <td>111</td>
                                    </tr>
                                    <tr>
                                        <td>与澳门地区电话通话情况</td>
                                        <td>111</td>
                                        <td>111</td>
                                    </tr>
                                    <tr>
                                        <td>与110通话情况</td>
                                        <td>111</td>
                                        <td>111</td>
                                    </tr>
                                    <tr>
                                        <td>与120通话情况</td>
                                        <td>111</td>
                                        <td>111</td>
                                    </tr>
                                    <tr>
                                        <td>与律师通话情况</td>
                                        <td>111</td>
                                        <td>111</td>
                                    </tr>
                                    <tr>
                                        <td>与法院通话情况</td>
                                        <td>111</td>
                                        <td>111</td>
                                    </tr><tr>
                                        <td>与贷款类号码联系情况</td>
                                        <td>111</td>
                                        <td>111</td>
                                    </tr><tr>
                                        <td>与银行类号码联系情况</td>
                                        <td>111</td>
                                        <td>111</td>
                                    </tr><tr>
                                        <td>与信用卡类号码联系情况</td>
                                        <td>111</td>
                                        <td>111</td>
                                    </tr><tr>
                                        <td>与催收类号码联系情况</td>
                                        <td>111</td>
                                        <td>111</td>
                                    </tr><tr>
                                        <td>夜间活动情况（0点-7点）</td>
                                        <td>1111</td>
                                        <td>111</td>
                                    </tr>
                                    <tr>
                                        <td>居住地本地（省份）地址在电商中使用时长</td>
                                        <td>111</td>
                                        <td>111</td>
                                    </tr>
                                    <tr>
                                        <td>总体电商使用情况</td>
                                        <td>111</td>
                                        <td>111</td>
                                    </tr>
                                    <tr>
                                        <td>总体电商使用情况</td>
                                        <td>111</td>
                                        <td>111</td>
                                    </tr>
                                    <tr>
                                        <td>申请人本人电商使用情况</td>
                                        <td>111</td>
                                        <td> behaviorCheck['person_ebusiness_info']['evidence'] </td>
                                    </tr>
                                    <tr>
                                        <td>彩票购买情况</td>
                                        <td> behaviorCheck['lottery_buying']['result'] </td>
                                        <td> behaviorCheck['lottery_buying']['evidence'] </td>
                                    </tr>
                                    <tr>
                                        <td>号码通话情况</td>
                                        <td> behaviorCheck['phone_call']['result'] </td>
                                        <td> behaviorCheck['phone_call']['evidence'] </td>
                                    </tr>
                                    </tbody>
                                </table>
                                通话详单
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                        <tr>
                                            <td colspan="12" class="text-center">
                                                <h5>通话详单</h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>序号</td>
                                            <td>联系人号码</td>
                                            <td>归属地</td>
                                            <td>标识</td>
                                            <td>近一周通过次数</td>
                                            <td>近一个月通话次数</td>
                                            <td>近三个月通话次数(</td>
                                            <td>近六个月通话次数</td>
                                        </tr>
                                            <tr>
                                                <td> loop->index + 1 </td>
                                                <td> callContact['peer_num'] </td>
                                                <td> callContact['city'] </td>
                                                <td> callContact['company_name'] </td>
                                                <td> callContact['call_cnt_1w'] </td>
                                                <td> callContact['call_cnt_1m'] </td>
                                                <td> callContact['call_cnt_3m'] </td>
                                                <td> callContact['call_cnt_6m'] </td>
                                            </tr>
                                    </tbody>
                                </table>
                                联系人区域汇总
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                        <tr>
                                            <td colspan="12" class="text-center">
                                                <h5>联系人区域汇总</h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>地区</td>
                                            <td>通话号码数</td>
                                            <td>通话次数</td>
                                            <td>通话时长(秒)</td>
                                            <td>主叫次数</td>
                                            <td>主叫时长</td>
                                            <td>被叫次数</td>
                                            <td>被叫时长</td>
                                        </tr>
                                            <tr>
                                                <td> value['region_loc'] </td>
                                                <td> value['region_uniq_num_cnt'] </td>
                                                <td> value['region_call_cnt'] </td>
                                                <td> value['region_call_time'] </td>
                                                <td> value['region_dial_cnt'] </td>
                                                <td> value['region_dial_time'] </td>
                                                <td> value['region_dialed_cnt'] </td>
                                                <td> value['region_dialed_time'] </td>
                                            </tr>
                                    </tbody>
                                </table>
                                亲情号通话详单
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="12" class="text-center">
                                            <h5>亲情号通话详单</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>号码</td>
                                        <td>是否亲情网用户</td>
                                        <td>是否亲情网户主</td>
                                        <td>连续充值月数</td>
                                        <td>常用联系地址是否手机归属地</td>
                                        <td>通话次数</td>
                                        <td>费用使用情况</td>
                                        <td>本机号码归属地使用情况</td>
                                    </tr>
                                    <tr>
                                        <td> userBasic['mobile'] </td>
                                        <td> callFamilyDetail['is_family_member'] </td>
                                        <td> callFamilyDetail['is_family_master'] </td>
                                        <td> callFamilyDetail['continue_recharge_month_cnt'] </td>
                                        <td> callFamilyDetail['is_address_match_attribution'] </td>
                                        <td>通话次数 小于 使用月数＊1次 : callFamilyDetail['is_address_match_attribution'] </td>
                                        <td> callFamilyDetail['unpaid_month_cnt'] </td>
                                        <td> callFamilyDetail['live_month_cnt'] </td>
                                    </tr>
                                    </tbody>
                                </table>
                                亲情号通话汇总
                                <table class="table table-condensed table-hover" width="100%">
                                <tbody>
                                <tr>
                                <td colspan="4" class="text-center">
                                <h5>亲情号通话汇总</h5>
                                </td>
                                </tr>
                                <tr>
                                <td>周期</td>
                                <td>近一个月</td>
                                <td>近三个月</td>
                                <td>近六个月</td>
                                </tr>
                                <tr>
                                <td>通话数量</td>
                                <td>9</td>
                                <td>34</td>
                                <td>67</td>
                                </tr>
                                </tbody>
                                </table>
                                通话风险分析
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <h5>通话风险分析</h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>通话类型</td>
                                            <td>分析描述</td>
                                        </tr>
                                            <tr>
                                                <td> key </td>
                                                <td>
                                                    1个月
                                                    近1个月通话总次数 analysis['call_cnt_1m'] 
                                                    近1个月通话总时长 analysis['call_cnt_1m'] 
                                                    近1个月主叫通话次数 analysis['call_analysis_dial_point']['call_dial_cnt_1m'] 
                                                    近1个月主叫通话总时长 analysis['call_analysis_dial_point']['call_dial_time_1m'] 
                                                    近1个月被叫通话次数 analysis['call_analysis_dialed_point']['call_dialed_cnt_1m'] 
                                                    近1个月被叫通话总时长 analysis['call_analysis_dialed_point']['call_dialed_time_1m']  <br>
                                                    3个月
                                                    近3个月通话总次数 analysis['call_cnt_3m'] 
                                                    近3个月通话总时长 analysis['call_cnt_3m'] 
                                                    近3个月主叫通话次数 analysis['call_analysis_dial_point']['call_dial_cnt_3m'] 
                                                    近3个月主叫通话总时长 analysis['call_analysis_dial_point']['call_dial_time_3m'] 
                                                    近3个月被叫通话次数 analysis['call_analysis_dialed_point']['call_dialed_cnt_3m'] 
                                                    近3个月被叫通话总时长 analysis['call_analysis_dialed_point']['call_dialed_time_3m']  <br>
                                                    6个月
                                                    近6个月通话总次数 analysis['call_cnt_6m'] 
                                                    近6个月通话总时长 analysis['call_cnt_6m'] 
                                                    近6个月主叫通话次数 analysis['call_analysis_dial_point']['call_dial_cnt_6m'] 
                                                    近6个月主叫通话总时长 analysis['call_analysis_dial_point']['call_dial_time_6m'] 
                                                    近6个月被叫通话次数 analysis['call_analysis_dialed_point']['call_dialed_cnt_6m'] 
                                                    近6个月被叫通话总时长 analysis['call_analysis_dialed_point']['call_dialed_time_6m']  <br>
                                                </td>
                                            </tr>
                                    </tbody>
                                </table>
                                暂无数据
                        </div>
                    </div>
                    <div id="tab-4" class="tab-pane">
                        <div class="panel-body">
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>基本信息</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">淘宝昵称</label></td>
                                        <td> ecommerceBaseInfo['taobaoAccount'] </td>
                                        <td><label class="control-label">绑定微博账号</label></td>
                                        <td> ecommerceBaseInfo['weiboAccount'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">姓名</label></td>
                                        <td> ecommerceBaseInfo['name'] </td>
                                        <td><label class="control-label">绑定微博昵称</label></td>
                                        <td> ecommerceBaseInfo['weiboNickName'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">电话号码</label></td>
                                        <td> ecommerceBaseInfo['mobile'] </td>
                                        <td><label class="control-label">首次交易时间</label></td>
                                        <td> ecommerceBaseInfo['alipayRegistrationDatetime'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">绑定邮箱</label></td>
                                        <td> ecommerceBaseInfo['email'] ?: '暂无数据' </td>
                                        <td><label class="control-label">绑定支付宝账号</label></td>
                                        <td> ecommerceBaseInfo['alipayAccount'] ?? '暂无数据' </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>全部收货地址</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">姓名</label></td>
                                        <td><label class="control-label">电话</label></td>
                                        <td><label class="control-label">邮编</label></td>
                                        <td><label class="control-label">地址</label></td>
                                    </tr>
                                            <tr>
                                                <td> ecommerceConsigneeAddress['receiveName'] ?? '暂无数据' </td>
                                                <td> ecommerceConsigneeAddress['telNumber'] </td>
                                                <td> ecommerceConsigneeAddress['postCode'] ?? '暂无数据' </td>
                                                <td> (ecommerceConsigneeAddress['region'] ?? '') . ecommerceConsigneeAddress['address'] </td>
                                            </tr>
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                暂无数据
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <h5>最近订单收货地址</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">订单时间</label></td>
                                        <td><label class="control-label">姓名</label></td>
                                        <td><label class="control-label">收货地址</label></td>
                                        <td><label class="control-label">手机</label></td>
                                        <td><label class="control-label">邮编</label></td>
                                    </tr>
                                        <tr>
                                            <td> date('Y-m-d H:i:s', lastTaobaoOrder['createTime']) ?? '暂无数据' </td>
                                            <td> lastTaobaoOrder['address']['receiveName'] ?? '暂无数据' </td>
                                            <td> lastTaobaoOrder['address']['address'] ?? '暂无数据' </td>
                                            <td> lastTaobaoOrder['address']['telNumber'] ?? '暂无数据' </td>
                                            <td> lastTaobaoOrder['address']['postCode'] ?? '暂无数据' </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                暂无数据
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <h5>最近6个月订单信息</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">订单时间</label></td>
                                        <td><label class="control-label">订单号</label></td>
                                        <td><label class="control-label">店铺</label></td>
                                        <td><label class="control-label">卖家</label></td>
                                        <td><label class="control-label">金额（元）</label></td>
                                        <td><label class="control-label">交易类型分类</label></td>
                                        <td><label class="control-label">交易状态</label></td>
                                    </tr>
                                            <tr>
                                                <td> date('Y-m-d H:i:s', orderItem['createTime']) </td>
                                                <td> orderItem['orderNumber'] </td>
                                                <td> orderItem['seller']['shopName'] ?? '暂无数据' </td>
                                                <td> orderItem['seller']['nick'] </td>
                                                <td>
                                                </td>
                                                <td> orderItem['tradeTypeName'] ?? '暂无数据' </td>
                                                <td> orderItem['tradeStatusName'] ?? '暂无数据' </td>
                                            </tr>
                                            <tr>
                                                <td><label class="control-label">合计笔数(成功的交易为准)</label></td>
                                                <td colspan="2"> lastSixMonthOrdersSuccess 笔</td>
                                                <td><label class="control-label">合计金额</label></td>
                                                <td colspan="3"> actualCount </td>
                                            </tr>
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                暂无数据
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                暂无数据
                        </div>
                    </div>
                    <div id="tab-5" class="tab-pane">
                        <div class="panel-body">
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>基本信息</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">姓名</label></td>
                                        <td> ecommerceBaseInfo['name'] </td>
                                        <td><label class="control-label">支付宝注册时间</label></td>
                                        <td> ecommerceBaseInfo['alipayRegistrationDatetime'] ?? '暂无数据' </td>
                                        <td colspan="2"><label class="control-label">性别</label></td>
                                        <td>无此数据-？？？</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">邮箱</label></td>
                                        <td> ecommerceBaseInfo['email'] ?: '暂无数据' </td>
                                        <td><label class="control-label">手机号</label></td>
                                        <td> ecommerceBaseInfo['mobile'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">身份证号</label></td>
                                        <td> ecommerceBaseInfo['identityCard'] ?? '暂无数据' </td>
                                        <td><label class="control-label">是否实名认证</label></td>
                                        <td> ecommerceBaseInfo['isVerified'] ? '是' : '否' </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">淘宝会员名</label></td>
                                        <td> ecommerceBaseInfo['taobaoAccount'] </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>资产状况</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">余额</label></td>
                                        <td> ecommerceBaseInfo['alipayBalance'] . '元' </td>
                                        <td><label class="control-label">余额宝</label></td>
                                        <td> isset(ecommerceBaseInfo['yuebaoBalance']) ? ecommerceBaseInfo['yuebaoBalance'] . '元' : '暂无数据' </td>
                                    </tr>
                                    <tr>
                                    <td><label class="control-label">存金宝</label></td>
                                    <td>无此数据-？？？</td>
                                    <td><label class="control-label">淘宝理财</label></td>
                                    <td>无此数据-？？？</td>
                                    </tr>
                                    <tr>
                                    <td><label class="control-label">招财宝</label></td>
                                    <td>无此数据-？？？</td>
                                    <td><label class="control-label">基金</label></td>
                                    <td>无此数据-？？？</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">花呗额度</label></td>
                                        <td> (isset(huabeiInfo['huabeiAmount']) && !empty(huabeiInfo['huabeiAmount'])) ? huabeiInfo['huabeiAmount'] . '元' : '暂无数据' </td>
                                        <td><label class="control-label">借呗额度</label></td>
                                        <td> (isset(jiebeiInfo['jiebeiAmount']) && !empty(jiebeiInfo['jiebeiAmount'])) ? jiebeiInfo['jiebeiAmount'] . '元' : '暂无数据' </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <h5>绑定银行卡信息</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">银行卡</label></td>
                                        <td><label class="control-label">银行卡号</label></td>
                                        <td><label class="control-label">用户姓名</label></td>
                                        <td><label class="control-label">绑定手机号</label></td>
                                        <td><label class="control-label">绑定时间</label></td>
                                        <td><label class="control-label">开通快捷支付</label></td>
                                    </tr>
                                            <tr>
                                                <td> ecommerceBindedBankCard['bankName'] .' '. bankCardTypeMap[ecommerceBindedBankCard['cardType']] </td>
                                                <td> ecommerceBindedBankCard['cardFullNumber'] ?? '暂无数据' </td>
                                                <td> ecommerceBindedBankCard['cardOwnerName'] ?? '暂无数据' </td>
                                                <td> ecommerceBindedBankCard['mobile'] ?? '暂无数据' </td>
                                                <td> ecommerceBindedBankCard['applyTime'] ?? '暂无数据' </td>
                                                <td> ecommerceBindedBankCard['isExpress'] ? '是' : '否' </td>
                                            </tr>
                                        <tr>
                                            <td colspan="6" class="text-center">暂无数据</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <h5>花呗交易记录（近6个月）</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">交易时间</label></td>
                                        <td><label class="control-label">交易类型</label></td>
                                        <td><label class="control-label">资产类型</label></td>
                                        <td><label class="control-label">交易状态</label></td>
                                        <td><label class="control-label">交易金额(元)</label></td>
                                        <td><label class="control-label">交易详情</label></td>
                                    </tr>
                                            <tr>
                                                <td> huabeiEcommerceTrade['tradeTime'] </td>
                                                <td> huabeiEcommerceTrade['txTypeName'] ?? '暂无数据' </td>
                                                <td>花呗</td>
                                                <td> huabeiEcommerceTrade['tradeStatusName'] ?? '暂无数据' </td>
                                                <td> huabeiEcommerceTrade['amount'] </td>
                                                <td> huabeiEcommerceTrade['title'] </td>
                                            </tr>
                                            <tr>
                                                <td><label class="control-label">合计笔数(成功的交易为准)</label></td>
                                                <td colspan="2"> count(huabeiEcommerceTradesSuccess) 笔</td>
                                                <td><label class="control-label">合计金额</label></td>
                                                <td colspan="2"> array_sum(array_column(huabeiEcommerceTradesSuccess, 'amount')) </td>
                                            </tr>
                                        <tr>
                                            <td colspan="6" class="text-center">暂无数据</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <h5>银行卡交易记录（近6个月）</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">交易时间</label></td>
                                        <td><label class="control-label">交易类型</label></td>
                                        <td><label class="control-label">资产类型</label></td>
                                        <td><label class="control-label">交易状态</label></td>
                                        <td><label class="control-label">交易金额(元)</label></td>
                                        <td><label class="control-label">交易详情</label></td>
                                    </tr>
                                            <tr>
                                                <td> bankCardEcommerceTrade['tradeTime'] </td>
                                                <td> bankCardEcommerceTrade['txTypeName'] ?? '暂无数据' </td>
                                                <td>银行卡</td>
                                                <td> bankCardEcommerceTrade['tradeStatusName'] ?? '暂无数据' </td>
                                                <td> bankCardEcommerceTrade['amount'] </td>
                                                <td> bankCardEcommerceTrade['title'] </td>
                                            </tr>
                                            <tr>
                                                <td><label class="control-label">合计笔数(成功的交易为准)</label></td>
                                                <td colspan="2"> count(bankCardEcommerceTradesSuccess) 笔</td>
                                                <td><label class="control-label">合计金额</label></td>
                                                <td colspan="2"> array_sum(array_column(bankCardEcommerceTradesSuccess, 'amount')) </td>
                                            </tr>
                                        <tr>
                                            <td colspan="6" class="text-center">暂无数据</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>信用卡还款记录（近6个月）</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">还款时间</label></td>
                                        <td><label class="control-label">交易号</label></td>
                                        <td><label class="control-label">交易状态</label></td>
                                        <td><label class="control-label">金额(元)</label></td>
                                    </tr>
                                            <tr>
                                                <td> repayCertifyCardEcommerceTrade['tradeTime'] </td>
                                                <td> repayCertifyCardEcommerceTrade['tradeNo'] </td>
                                                <td> repayCertifyCardEcommerceTrade['tradeStatusName'] ?? '暂无数据' </td>
                                                <td> repayCertifyCardEcommerceTrade['amount'] </td>
                                            </tr>
                                            <tr>
                                                <td><label class="control-label">合计笔数(成功的交易为准)</label></td>
                                                <td> count(repayCertifyCardEcommerceTradesSuccess) 笔</td>
                                                <td><label class="control-label">合计金额</label></td>
                                                <td> array_sum(array_column(repayCertifyCardEcommerceTradesSuccess, 'amount')) </td>
                                            </tr>
                                        <tr>
                                            <td colspan="4" class="text-center">暂无数据</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>花呗还款记录（近6个月）</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">花呗额度</label></td>
                                        <td> (isset(huabeiInfo['huabeiAmount']) && !empty(huabeiInfo['huabeiAmount'])) ? huabeiInfo['huabeiAmount'] . '元' : '暂无数据' </td>
                                        <td><label class="control-label">花呗是否逾期</label></td>
                                        <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">未还款期数</label></td>
                                        <td> huabeiInfo['huabeiOverdueBillCnt'] ?? '暂无数据' </td>
                                        <td><label class="control-label">未还款总金额</label></td>
                                        <td>暂无数据</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">逾期天数</label></td>
                                        <td> huabeiInfo['huabeiOverdueDays'] ?? '暂无数据' </td>
                                        <td><label class="control-label">罚息</label></td>
                                        <td> huabeiInfo['huabeiPenaltyAmount'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">当月还款额</label></td>
                                        <td> huabeiInfo['huabeiCurrentMonthPayment'] ?? '暂无数据' </td>
                                        <td><label class="control-label">下月还款额度</label></td>
                                        <td> huabeiInfo['huabeiNextMonthPayment'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr class="trbg">
                                        <td><label class="control-label">还款时间</label></td>
                                        <td><label class="control-label">交易号</label></td>
                                        <td><label class="control-label">交易状态</label></td>
                                        <td><label class="control-label">金额(元)</label></td>
                                    </tr>
                                            <tr>
                                                <td> repayHuabeiEcommerceTrade['tradeTime'] </td>
                                                <td> repayHuabeiEcommerceTrade['tradeNo'] </td>
                                                <td> repayHuabeiEcommerceTrade['tradeStatusName'] ?? '暂无数据' </td>
                                                <td> repayHuabeiEcommerceTrade['amount'] </td>
                                            </tr>
                                            <tr>
                                                <td><label class="control-label">合计笔数(成功的交易为准)</label></td>
                                                <td> count(repayHuabeiEcommerceTradesSuccess) 笔</td>
                                                <td><label class="control-label">合计金额</label></td>
                                                <td> array_sum(array_column(repayHuabeiEcommerceTradesSuccess, 'amount')) </td>
                                            </tr>
                                        <tr>
                                            <td colspan="4" class="text-center">暂无数据</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>借呗还款记录（近6个月）</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">借款额度</label></td>
                                        <td> jiebeiInfo['jiebeiAmount'] ?? '暂无数据' </td>
                                        <td><label class="control-label">借呗是否逾期</label></td>
                                        <td>
                                            111
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">未还期数</label></td>
                                        <td> jiebeiInfo['jiebeiUnClearLoanCount'] ?? '暂无数据' </td>
                                        <td><label class="control-label">未还总金额</label></td>
                                        <td>暂无数据</td>
                                    </tr>
                                    <tr class="trbg">
                                        <td><label class="control-label">还款时间</label></td>
                                        <td><label class="control-label">交易号</label></td>
                                        <td><label class="control-label">交易状态</label></td>
                                        <td><label class="control-label">金额(元)</label></td>
                                    </tr>
                                            <tr>
                                                <td> repayJiebeiEcommerceTrade['tradeTime'] </td>
                                                <td> repayJiebeiEcommerceTrade['tradeNo'] </td>
                                                <td> repayJiebeiEcommerceTrade['tradeStatusName'] ?? '暂无数据' </td>
                                                <td> repayJiebeiEcommerceTrade['amount'] </td>
                                            </tr>
                                            <tr>
                                                <td><label class="control-label">合计笔数(成功的交易为准)</label></td>
                                                <td> count(repayJiebeiEcommerceTradesSuccess) 笔</td>
                                                <td><label class="control-label">合计金额</label></td>
                                                <td> array_sum(array_column(repayJiebeiEcommerceTradesSuccess, 'amount')) </td>
                                            </tr>
                                        <tr>
                                            <td colspan="4" class="text-center">暂无数据</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <h5>交易记录（近6个月）</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">交易时间</label></td>
                                        <td><label class="control-label">交易类型</label></td>
                                        <td><label class="control-label">交易对方</label></td>
                                        <td><label class="control-label">商品名称</label></td>
                                        <td><label class="control-label">交易金额(元)</label></td>
                                        <td><label class="control-label">交易状态</label></td>
                                    </tr>
                                            <tr>
                                                <td> ecommerceTrade['tradeTime'] </td>
                                                <td> ecommerceTrade['txTypeName'] ?? '暂无数据' </td>
                                                <td> ecommerceTrade['otherSide'] ?? '暂无数据' </td>
                                                <td> ecommerceTrade['title'] </td>
                                                <td> ecommerceTrade['amount'] ? ecommerceTrade['amount'] : '暂无数据' </td>
                                                <td> ecommerceTrade['tradeStatusName'] ?? '暂无数据' </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><label class="control-label">合计笔数(成功的交易为准)</label></td>
                                                <td> count(ecommerceTradesSuccess) 笔</td>
                                                <td><label class="control-label">合计金额</label></td>
                                                <td colspan="2"> array_sum(array_column(ecommerceTradesSuccess, 'amount')) </td>
                                            </tr>
                                        <tr>
                                            <td colspan="6" class="text-center">暂无数据</td>
                                        </tr>
                                    </tbody>
                                </table>
                                暂无数据
                        </div>
                    </div>
                    <div class="tab-pane fade" id="multilateral-lending">
                        <div class="panel-body">
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <h5>贷款履约行为评估</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>姓名: basicInfo['name'] ?? (userBasic['name'] ?? '暂无数据') </td>
                                        <td>身份证号: basicInfo['id_card'] ?? (userBasic['id_card'] ?? '暂无数据') </td>
                                        <td>查询日期: multilateralLending->created_at </td>
                                    </tr>
                                    <tr class="trbg">
                                        <td colspan="2">评估项目</td>
                                        <td colspan="2">评估结果</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">贷款行为分</td>
                                        <td colspan="2"> multilateralLending->result_detail['loans_score'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">贷款行为置信度</td>
                                        <td colspan="2"> multilateralLending->result_detail['loans_credibility'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">贷款放款总订单数</td>
                                        <td colspan="2"> multilateralLending->result_detail['loans_count'] ?? '暂无数据'  </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">贷款已结清订单数</td>
                                        <td colspan="2"> multilateralLending->result_detail['loans_settle_count'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">贷款逾期订单数(M0+)</td>
                                        <td colspan="2"> multilateralLending->result_detail['loans_overdue_count'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">贷款机构数</td>
                                        <td colspan="2"> multilateralLending->result_detail['loans_org_count'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">消费金融类机构数</td>
                                        <td colspan="2"> multilateralLending->result_detail['consfin_org_count'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">网络贷款类机构数</td>
                                        <td colspan="2"> multilateralLending->result_detail['loans_cash_count'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">近1月贷款笔数</td>
                                        <td colspan="2"> multilateralLending->result_detail['latest_one_month'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">近3月贷款笔数</td>
                                        <td colspan="2"> multilateralLending->result_detail['latest_three_month'] ?? '暂无数据' </td>
                                    </tr><tr>
                                        <td colspan="2">近6月贷款笔数</td>
                                        <td colspan="2"> multilateralLending->result_detail['latest_six_month'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">最近一次贷款时间</td>
                                        <td colspan="2"> multilateralLending->result_detail['loans_latest_time'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">信用贷款时长</td>
                                        <td colspan="2"> multilateralLending->result_detail['loans_long_time'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">历史贷款机构成功扣款笔数</td>
                                        <td colspan="2"> multilateralLending->result_detail['history_suc_fee'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">历史贷款机构失败扣款笔数</td>
                                        <td colspan="2"> multilateralLending->result_detail['history_fail_fee'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">近1月贷款机构成功扣款笔数</td>
                                        <td colspan="2"> multilateralLending->result_detail['latest_one_month_suc'] ?? '暂无数据' </td>
                                    </tr><tr>
                                        <td colspan="2">近1月贷款机构失败扣款笔数</td>
                                        <td colspan="2"> multilateralLending->result_detail['latest_one_month_fail'] ?? '暂无数据' </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <br>
                                <span>
                                    特别说明：<br>
                                    1.贷款行为分/置信度: 新颜征信综合自身海量用户的历史贷款数据，利用机器学习的方法构建贷款行为动态评估模型，并由此计算出用户的贷款行为分及置信 度。 其中，贷款行为分是对该用户历史贷款行为的综合评估，取值范围1-1000分;置信度是对贷款行为分的结果可靠程度的评估，取值范围50-100分。
                                </span>
                                暂无数据
                        </div>
                    </div>
                    <div id="tab-6" class="tab-pane">
                        <div class="panel-body">
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>基本信息</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">姓名：</label></td>
                                        <td> personInfo['name'] </td>
                                        <td><label class="control-label">身份证号码：</label></td>
                                        <td> personInfo['idcard']  有效</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">性别：</label></td>
                                        <td> personInfo['gender'] </td>
                                        <td><label class="control-label">年龄：</label></td>
                                        <td> personInfo['age'] </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">身份证归属地：</label></td>
                                        <td> personInfo['idcard_location'] </td>
                                        <td><label class="control-label">运营商 ：</label></td>
                                        <td> personInfo['carrier'] </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">手机号码归属地：</label></td>
                                        <td> personInfo['mobile_location'] </td>
                                        <td><label class="control-label">邮箱 ：</label></td>
                                        <td> personInfo['email'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">所在单位：</label></td>
                                        <td> personInfo['company'] ?? '暂无数据' </td>
                                        <td><label class="control-label">单位类型 ：</label></td>
                                        <td> personInfo['company_type'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">家庭住址：</label></td>
                                        <td colspan="3"> personInfo['home_address'] ?? '暂无数据' </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>基本信息校验</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">是否导入运营商数据：</label></td>
                                        <td> verifInfo['has_carrier_data'] ? '是' : '否' </td>
                                        <td><label class="control-label">是否导入公积金数据：</label></td>
                                        <td> verifInfo['has_fund_data'] ? '是' : '否' </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">是否导入网银数据：</label></td>
                                        <td> verifInfo['has_onlinebank_data'] ? '是' : '否' </td>
                                        <td><label class="control-label">身份证号码是否与公积金数据匹配：</label></td>
                                        <td> isset(verifInfo['idcard_match_fund']) ? (verifInfo['idcard_match_fund'] ? '是' : '否' ) : '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">姓名是否与公积金数据匹配：</label></td>
                                        <td> isset(verifInfo['mobile_match_fund']) ? (verifInfo['mobile_match_fund'] ? '是' : '否' ) : '暂无数据' </td>
                                        <td><label class="control-label">手机号码是否与公积金数据匹配：</label></td>
                                        <td> isset(verifInfo['name_match_fund']) ? (verifInfo['name_match_fund'] ? '是' : '否' ) : '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">身份证号码是否与网银数据匹配：</label></td>
                                        <td> isset(verifInfo['idcard_match_onlinebank']) ? (verifInfo['idcard_match_onlinebank'] ? '是' : '否' ) : '暂无数据' </td>
                                        <td><label class="control-label">姓名是否与网银数据匹配：</label></td>
                                        <td> isset(verifInfo['mobile_match_onlinebank']) ? (verifInfo['mobile_match_onlinebank'] ? '是' : '否' ) : '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">手机号码是否与网银数据匹配：</label></td>
                                        <td colspan="3"> isset(verifInfo['name_match_onlinebank']) ? (verifInfo['name_match_onlinebank'] ? '是' : '否' ) : '暂无数据' </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>黑名单信息</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">所属</label></td>
                                        <td>本人</td>
                                        <td><label class="control-label">涉黑评分（分数区间为0-100，40分以下为高危人群）：</label></td>
                                        <td> backInfoDetail['match_score'] </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">手机和姓名是否在黑名单：</label></td>
                                        <td> backInfoDetail['mobile_name_in_blacklist'] ? '是' : '否' </td>
                                        <td><label class="control-label">手机和姓名黑名单更新时间：</label></td>
                                        <td> backInfoDetail['mobile_name_blacklist_updated_time'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">身份证和姓名是否在黑名单：</label></td>
                                        <td> backInfoDetail['idcard_name_in_blacklist'] ? '是' : '否' </td>
                                        <td><label class="control-label">身份证和姓名黑名单更新时间：</label></td>
                                        <td> backInfoDetail['idcard_name_blacklist_updated_time'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">被标记的黑名单分类：</label></td>
                                        <td colspan="3"> isset(backInfoDetail['direct_black_type']) ? (backInfoDetail['direct_black_type'] ? '是' : '否' ) : '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">累计借入本金（元）：</label></td>
                                        <td> blacklistRecord['capital'] ?? '暂无数据'</td>
                                        <td><label class="control-label">累计已还金额：</label></td>
                                        <td> blacklistRecord['paid_amount'] ?? '暂无数据'</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">累计逾期金额（元）：</label></td>
                                        <td> blacklistRecord['overdue_amount'] ?? '暂无数据'</td>
                                        <td><label class="control-label">最大逾期天数：</label></td>
                                        <td> isset(blacklistRecord['overdue_status']) ? overdue_status[blacklistRecord['overdue_status']] : '暂无数据'</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>联系人</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">直接联系人在黑名单数量：</label></td>
                                        <td> backInfoDetail['direct_black_count'] ?? '暂无数据'</td>
                                        <td><label class="control-label">直接联系人总数：</label></td>
                                        <td> backInfoDetail['direct_contact_count'] ?? '暂无数据'</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">间接联系人在黑名单数量：</label></td>
                                        <td> backInfoDetail['indirect_black_count'] ?? '暂无数据'</td>
                                        <td><label class="control-label">引起黑名单的直接联系人数量：</label></td>
                                        <td> backInfoDetail['introduce_black_count'] ?? '暂无数据'</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">引起黑名单的直接联系人占比：</label></td>
                                        <td> backInfoDetail['introduce_black_ratio'] ?? '暂无数据'</td>
                                        <td><label class="control-label">被标记的黑名单分类：</label></td>
                                        <td> backInfoDetail['direct_black_type'] ?? '暂无数据'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>亲密联系人</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">直接亲密联系人在黑名单数量：</label></td>
                                        <td> backInfoDetail['direct_intimate_black_count'] ?? '暂无数据'</td>
                                        <td><label class="control-label">直接亲密联系人总数：</label></td>
                                        <td> backInfoDetail['direct_intimate_contact_count'] ?? '暂无数据'</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">间接亲密联系人在黑名单数量：</label></td>
                                        <td> backInfoDetail['indirect_intimate_black_count'] ?? '暂无数据'</td>
                                        <td><label class="control-label">引起黑名单的直接亲密联系人数量：</label></td>
                                        <td> backInfoDetail['introduce_intimate_black_count'] ?? '暂无数据'</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">引起黑名单的直接亲密联系人占比：</label></td>
                                        <td> backInfoDetail['introduce_intimate_black_ratio'] ?? '暂无数据'</td>
                                        <td><label class="control-label">被标记的黑名单分类：</label></td>
                                        <td> backInfoDetail['direct_intimate_black_type'] ?? '暂无数据'</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>灰名单信息</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">手机和姓名是否在灰名单：</label></td>
                                        <td> grayInfoDetail['mobile_name_in_gray'] ? '是' : '否'</td>
                                        <td><label class="control-label">手机和姓名灰名单更新时间：</label></td>
                                        <td> grayInfoDetail['mobile_name_gray_updated_time'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">身份证和姓名是否在灰名单：</label></td>
                                        <td> grayInfoDetail['idcard_name_in_gray'] ? '是' : '否' </td>
                                        <td><label class="control-label">身份证和姓名灰名单更新时间：</label></td>
                                        <td> grayInfoDetail['idcard_name_gray_updated_time'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">被标记的灰名单分类：</label></td>
                                        <td colspan="3"> grayInfoDetail['gray_types'][0] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">累计借入本金：</label></td>
                                        <td> grayRecord['capital'] ?? '暂无数据' </td>
                                        <td><label class="control-label">累计已还金额：</label></td>
                                        <td> grayRecord['paid_amount'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">累计逾期金额：</label></td>
                                        <td> grayRecord['overdue_amount'] ?? '暂无数据' </td>
                                        <td><label class="control-label">最大逾期天数：</label></td>
                                        <td> isset(grayRecord['overdue_status']) ? overdue_status[grayRecord['overdue_status']] : '暂无数据' </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>多头信息</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">注册机构数量：</label></td>
                                        <td> registerInfo['org_count'] </td>
                                        <td><label class="control-label">注册机构类型：</label></td>
                                        <td> \App\Strategies\WandStrategy::getOrgTypeText(registerInfo['org_types']) ?: '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">机构查询统计：</label></td>
                                        <td colspan="3"> registerInfo['org_count'] </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <h5>多头借贷分析</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>机构类型</td>
                                        <td>15天内贷款申请次数</td>
                                        <td>1个月内贷款申请次数</td>
                                        <td>3个月内贷款申请次数</td>
                                        <td>6个月内贷款申请次数</td>
                                    </tr>
                                        <tr>
                                            <td> orgTyepMap[item['org_type']] ?? '暂无数据' </td>
                                            <td> item['loan_cnt_15d'] </td>
                                            <td> item['loan_cnt_30d'] </td>
                                            <td> item['loan_cnt_90d'] </td>
                                            <td> item['loan_cnt_180d'] </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>机构查询历史信息</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>查询日期</td>
                                        <td>机构类型</td>
                                        <td>是否本机构查询</td>
                                    </tr>
                                        <tr>
                                            <td> item['date'] </td>
                                            <td> orgTyepMap[item['org_type']] ?? '暂无数据' </td>
                                            <td> item['is_self'] ? '是' : '否' </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>手机存疑</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>使用过此手机的其他姓名</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">最后使用时间：</label></td>
                                        <td> suspiciousMobile['other_names']['latest_used_time'] ?? '暂无数据' </td>
                                        <td><label class="control-label">姓名：</label></td>
                                        <td> suspiciousMobile['other_names']['name'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>使用过此手机的其他身份证</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">最后使用时间：</label></td>
                                        <td> suspiciousMobile['other_idcards']['latest_used_time'] ?? '暂无数据' </td>
                                        <td><label class="control-label">身份证号码：</label></td>
                                        <td> suspiciousMobile['other_idcards']['idcard'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>提供数据的机构类型</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">最后使用时间：</label></td>
                                        <td> suspiciousMobile['information_sources']['latest_used_time'] ?? '暂无数据' </td>
                                        <td><label class="control-label">机构类型：</label></td>
                                        <td> isset(suspiciousMobile['information_sources']['org_type']) ? orgTypeMap[suspiciousMobile['information_sources']['org_type']] : '暂无数据' </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>身份证存疑</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>使用过此身份证的其他姓名</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">最后使用时间：</label></td>
                                        <td> suspiciousIdcard['other_names']['latest_used_time'] ?? '暂无数据' </td>
                                        <td><label class="control-label">身份证号码：</label></td>
                                        <td> suspiciousIdcard['other_names']['name'] ?? '暂无数据' </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <h5>使用过此身份证的其他手机</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">最后使用时间：</label></td>
                                        <td> suspiciousIdcard['other_mobiles']['latest_used_time'] ?? '暂无数据' </td>
                                        <td><label class="control-label">手机号码：</label></td>
                                        <td> suspiciousIdcard['other_mobiles']['mobile'] ?? '暂无数据' </td>
                                        <td><label class="control-label">运营商名称：</label></td>
                                        <td> suspiciousIdcard['other_mobiles']['carrier'] ?? '暂无数据' </td>
                                        <td><label class="control-label">号码归属地：</label></td>
                                        <td> suspiciousIdcard['other_mobiles']['mobile_location'] ?? '暂无数据' </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>提供数据的机构类型</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">最后使用时间：</label></td>
                                        <td> suspiciousIdcard['information_sources']['latest_used_time'] ?? '暂无数据' </td>
                                        <td><label class="control-label">机构类型：</label></td>
                                        <td> isset(suspiciousIdcard['information_sources']['org_type']) ? orgTypeMap[suspiciousIdcard['information_sources']['org_type']] : '暂无数据' </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>公积金账户</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">最近数据更新时间：</label></td>
                                        <td> fundInfos['fund_basic']['update_date'] ?? '暂无数据' </td>
                                        <td><label class="control-label">开户时间：</label></td>
                                        <td> fundInfos['fund_basic']['open_date'] ?? '暂无数据'  </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">开户地区：</label></td>
                                        <td> fundInfos['fund_basic']['open_location'] ?? '暂无数据'  </td>
                                        <td><label class="control-label">账户状态：</label></td>
                                        <td> fundInfos['fund_basic']['account_status'] ?? '暂无数据'  </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">账户余额：</label></td>
                                        <td> fundInfos['fund_basic']['balance'] ?? '暂无数据'  </td>
                                        <td><label class="control-label">月缴金额：</label></td>
                                        <td> fundInfos['fund_basic']['monthly_income'] ?? '暂无数据'  </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">基数：</label></td>
                                        <td> fundInfos['fund_basic']['base_amount'] ?? '暂无数据'  </td>
                                        <td><label class="control-label">最近缴纳时间：</label></td>
                                        <td> fundInfos['fund_basic']['last_pay_date'] ?? '暂无数据'  </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">近一年缴纳月数：</label></td>
                                        <td> fundInfos['fund_statistics']['total_months'] ?? '暂无数据'  </td>
                                        <td><label class="control-label">近一年缴纳单位数：</label></td>
                                        <td> fundInfos['fund_statistics']['total_companies'] ?? '暂无数据'  </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">近一年连续缴纳月数：</label></td>
                                        <td> fundInfos['fund_statistics']['continuous_months'] ?? '暂无数据'  </td>
                                        <td><label class="control-label">近一年补缴次数：</label></td>
                                        <td> fundInfos['fund_statistics']['repay_times'] ?? '暂无数据'  </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>借记卡</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">最近数据更新时间：</label></td>
                                        <td> debitCardInfo['update_date'] ?? '暂无数据' </td>
                                        <td><label class="control-label">卡片数目：</label></td>
                                        <td> debitCardInfo['card_amount'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">总余额：</label></td>
                                        <td> debitCardInfo['balance'] ?? '暂无数据' </td>
                                        <td><label class="control-label">近一年总收入：</label></td>
                                        <td> debitCardInfo['total_income'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">近一年工资收入：</label></td>
                                        <td> debitCardInfo['total_salary_income'] ?? '暂无数据' </td>
                                        <td><label class="control-label">近一年贷款收入：</label></td>
                                        <td> debitCardInfo['total_loan_income'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">近一年总支出：</label></td>
                                        <td> debitCardInfo['total_outcome'] ?? '暂无数据' </td>
                                        <td><label class="control-label">近一年消费支出：</label></td>
                                        <td> debitCardInfo['total_consume_outcome'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">近一年还贷支出：</label></td>
                                        <td colspan="3"> debitCardInfo['total_loan_outcome'] ?? '暂无数据' </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>信用卡</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">最近数据更新时间：</label></td>
                                        <td> creditCardInfo['update_date'] ?? '暂无数据' </td>
                                        <td><label class="control-label">卡片数目：</label></td>
                                        <td> creditCardInfo['card_amount'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">总信用额：</label></td>
                                        <td> creditCardInfo['total_credit_limit'] ?? '暂无数据' </td>
                                        <td><label class="control-label">总可用信用额：</label></td>
                                        <td> creditCardInfo['total_credit_available'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">单一银行最高信用额：</label></td>
                                        <td> creditCardInfo['max_credit_limit'] ?? '暂无数据' </td>
                                        <td><label class="control-label">近一年逾期次数：</label></td>
                                        <td> creditCardInfo['overdue_times'] ?? '暂无数据' </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">近一年逾期月数：</label></td>
                                        <td colspan="3"> creditCardInfo['overdue_months'] ?? '暂无数据' </td>
                                    </tr>
                                    </tbody>
                                </table>
                                暂无数据
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
