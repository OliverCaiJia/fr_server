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
                    <a class="menuid btn btn-primary btn-sm" href="{{URL::previous()}}">返回</a>
                </div>
                <div class="row">
                    <div class="col-sm-8" style="text-align: right">
                        @if($status == \App\Constants\OrderConstant::ORDER_STATUS_PENDING)
                            @if(substr(url()->previous(), -5) != 'order')
                                <a href="{{ route('admin.order.pending.detail.passOrder') }}?order_id={{$order->id}}">
                                    <button class="btn btn-primary btn-sm" type="button">
                                        通过审批
                                    </button>
                                </a>
                                <a href="{{ route('admin.order.pending.detail.refuseOrder') }}?order_id={{$order->id}}">
                                    <button class="btn btn-primary btn-sm" type="button">
                                        拒绝申请
                                    </button>
                                </a>
                            @endif
                        @endif
                        @if($status == \App\Constants\OrderConstant::ORDER_STATUS_PASSED)
                            <a href="{{ route('admin.order.loan.pass') }}?order_id={{$order->id}}&type=loan">
                                <button class="btn btn-primary btn-sm" type="button">
                                    立即放款
                                </button>
                            </a>
                            <a href="{{ route('admin.order.loan.refuse') }}?order_id={{$order->id}}">
                                <button class="btn btn-primary btn-sm" type="button">
                                    拒绝放款
                                </button>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#tab-1" aria-expanded="true">
                            申请信息
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#tab-2" aria-expanded="false">
                            运营商
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#tab-4" aria-expanded="false">
                            淘宝
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#tab-5" aria-expanded="false">
                            支付宝
                        </a>
                    </li>
                    <li>
                        <a href="#multilateral-lending" role="tab" data-toggle="tab">
                            多头借贷
                        </a>
                    </li>
                    <li>
                        <a href="#iou-platform" role="tab" data-toggle="tab">
                            借条平台
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#tab-6" aria-expanded="false">
                            综合信用
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <?php $carrier = \App\Models\Factory\Admin\Order\CertifyCarrierFactory::getById($order->userReport->carrier_id); ?>
                            <?php $basicInfo = \App\Models\Factory\Admin\Order\OrderBasicInfoFactory::getById($order->userReport->basic_info_id);?>
                            <?php $userBasic = $carrier->user_basic ?? '';?>
                            <table class="table table-condensed table-hover" width="100%">
                                <tbody>
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <h5>基本信息</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">姓名：</label></td>
                                    <td>{{ $basicInfo['name'] ?? '暂无数据' }}
                                        @if($order->userReport->basic_info_id)
                                            <span class="status">已三要素实名认证</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">身份证号：</label></td>
                                    <td>
                                        {{ $basicInfo['id_card'] ?? '暂无数据' }}
                                        @if($order->userReport->basic_info_id)
                                            <span class="status">已三要素实名认证</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">手机号：</label></td>
                                    <td>{{ $basicInfo['mobile'] ?? ($userBasic['mobile'] ?? \App\Models\Factory\Admin\Users\UsersFactory::getUserInfoById($order->userReport->user_id)['mobile']) }}
                                        @if($carrier)
                                            <span class="status">运营商已认证</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">芝麻分：</label></td>
                                    <td>
                                        @if(isset($order->userReport->zhima_score) && $order->userReport->zhima_score > 0)
                                            <span class="zhima">{{ $order->userReport->zhima_score }}</span>
                                            <span class="status">芝麻分已认证</span>
                                        @else
                                            暂无数据
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">微信号：</label></td>
                                    <td>{{ isset($basicInfo['wechat_id']) ? ($basicInfo['wechat_id'] ?: '暂无数据') : '暂无数据' }}</td>
                                </tr>
                                <?php $contacts = $basicInfo->contacts[0] ?? ''; ?>
                                <tr>
                                    <td><label class="control-label"> 紧急联系人：</label></td>
                                    <td>{{ isset($contacts['relationship']) ? ($contacts['relationship'] ?: '暂无数据') : '暂无数据' }}</td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">姓名：</label></td>
                                    <td>{{ isset($contacts['name']) ? ($contacts['name'] ?: '暂无数据') : '暂无数据' }}</td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">手机号：</label></td>
                                    <td>{{ isset($contacts['mobile']) ? ($contacts['mobile'] ?: '暂无数据') : '暂无数据' }}</td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">月收入：</label></td>
                                    <td>{{ isset($basicInfo['monthly_income']) ? ($basicInfo['monthly_income'] ? \App\Strategies\OrderDetailStrategy::getMonthlyIncomeTextForBlade($basicInfo['monthly_income']) : '暂无数据') : '暂无数据' }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <h5>户籍信息</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">年龄：</label></td>
                                    <td>{{ isset($basicInfo['id_card']) ? (isset($userBasic['age']) ? $userBasic['age'] : \App\Strategies\UserReportStrategy::getAgeByIdCardForBlade($basicInfo['id_card'] ?? ($userBasic['id_card'] ?? ''))) : '暂无数据' }}</td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">性别：</label></td>
                                    <td>{{ isset($basicInfo['id_card']) ? (isset($userBasic['gender']) ? $userBasic['gender'] : \App\Strategies\UserReportStrategy::getGenderByIdCardForBlade($basicInfo['id_card'] ?? ($userBasic['id_card'] ?? ''))) : '暂无数据' }}</td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">户籍地址：</label></td>
                                    <td>{{ isset($basicInfo['id_card']) ? (isset($userBasic['native_place']) ? $userBasic['native_place'] : ($basicInfo['province'].$basicInfo['city'].$basicInfo['region'] ?: '暂无数据')) : '暂无数据' }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <h5>贷款信息</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">渠道：</label></td>
                                    <td>{{ \App\Models\Factory\Saas\Channel\ChannelFactory::getNameById($order->channel_id) }}</td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">申请金额：</label></td>
                                    <td>{{ $order->amount ? $order->amount . '元' : '' }} </td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">周期：</label></td>
                                    <td>{{ $order->cycle ? $order->cycle . '天' : '' }}</td>
                                </tr>
                                <tr>
                                    <td><label class="control-label">还款方式：</label></td>
                                    <td>
                                        @if($order->repayment_method == 1)
                                            一次还
                                        @elseif($order->repayment_method == 2)
                                            分期还
                                        @endif
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="tab-2" class="tab-pane">
                        <div class="panel-body">
                            @if($carrier)
                                <table class="table table-condensed table-hover" width="100%">
                                    <?php $userBasic = $carrier->user_basic; ?>
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>基本信息</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">手机号：</label></td>
                                        <td>{{ $userBasic['mobile'] }}</td>
                                        <td><label class="control-label">姓名：</label></td>
                                        <td>{{ $userBasic['name'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">证件号：</label></td>
                                        <td><label class="control-label">{{ $userBasic['id_card'] }}</label></td>
                                        <td><label class="control-label">报告获取时间：</label></td>
                                        <?php $assignedAt = \App\Strategies\UserReportStrategy::getAssignedAt($order->id, Auth::user()->saas_auth_id); ?>
                                        <td>{{ $assignedAt }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label"> 运营商：</label></td>
                                        <td>{{ $userBasic['source_name_zh'] }}</td>
                                        <td><label class="control-label">帐号状态：</label></td>
                                        <td>1-单向停机</td>
                                    <tr>
                                        <td><label class="control-label">开户时间：</label></td>
                                        <td>{{ $userBasic['reg_time'] ?? '' }}</td>
                                        <td><label class="control-label">开户时长：</label></td>
                                        <td>{{ $userBasic['in_time'] ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">用户邮箱：</label></td>
                                        <td>{{ isset($userBasic['email']) ? ($userBasic['email'] ?: '暂无数据') : '暂无数据' }}</td>
                                        <td><label class="control-label">用户地址：</label></td>
                                        <td>{{ $userBasic['address'] ?? ''}}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">手机号归属地：</label></td>
                                        <td>{{ $userBasic['phone_attribution'] }}</td>
                                        <td><label class="control-label">居住地址：</label></td>
                                        <td>{{ $userBasic['live_address'] ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">余额：</label></td>
                                        <td>{{ isset($userBasic['available_balance']) ? ($userBasic['available_balance'] / 100) . '元' : ''}}</td>
                                        <td><label class="control-label">套餐：</label></td>
                                        <td>{{ $userBasic['package_name'] ?? '' }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                {{--基本信息校验--}}
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <?php $basicCheck = $carrier->basic_check_items;?>
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <h5>基本信息校验</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">名称</td>
                                        <td colspan="2">结果</td>
                                    </tr>
                                    {{--<tr>--}}
                                        {{--<td colspan="2">身份证有效性</td>--}}
                                        {{--<td colspan="2">{{ $basicCheck['idcard_check']['result'] }}</td>--}}
                                    {{--</tr>--}}
                                    <tr>
                                        <td colspan="2">邮箱有效性</td>
                                        <td colspan="2">{{ $basicCheck['email_check']['result'] }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">地址有效性</td>
                                        <td colspan="2">{{ $basicCheck['address_check']['result'] }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">通过话记录完整性</td>
                                        <td colspan="2">{{ $basicCheck['call_data_check']['result'] }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">身份证号码是否与运营商数据匹配</td>
                                        <td colspan="2">{{ $basicCheck['idcard_match']['result'] }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">姓名是否与运营商数据匹配</td>
                                        <td colspan="2">{{ $basicCheck['name_match']['result'] }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">申请人姓名+身份证号码是否出现在法院黑名单</td>
                                        <td colspan="2">{{ $basicCheck['is_name_and_idcard_in_court_black']['result'] }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">申请人姓名+身份证号码是否出现在金融机构黑名单</td>
                                        <td colspan="2">{{ $basicCheck['is_name_and_idcard_in_finance_black']['result'] }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">申请人姓名+手机号码是否出现在金融机构黑名单</td>
                                        <td colspan="2">{{ $basicCheck['is_name_and_mobile_in_finance_black']['result'] }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                {{--联系人信息核对--}}
                                <?php $basicCheck = $carrier->application_check;?>
                                @if($basicCheck)
                                    <table class="table table-condensed table-hover" width="100%">
                                        <tbody>
                                        <tr>
                                            <td colspan="12" class="text-center">
                                                <h5>联系人信息核对</h5>
                                            </td>
                                        </tr>
                                        @foreach($basicCheck as $item)
                                            <tr>
                                                <td><label class="control-label">姓名：</label></td>
                                                <td>{{ $item['contact_name'] }}</td>
                                                <td><label class="control-label">与申请人关系：</label></td>
                                                <td>{{ $item['relationship'] }}</td>
                                                <td><label class="control-label">手机号：</label></td>
                                                <td>{{ $item['key_value'] }}</td>
                                                <td>{{ $item['check_xiaohao'] }}</td>
                                                <td><label class="control-label">与该联系人通话记录：</label></td>
                                                <td>{{ $item['check_mobile'] }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
                                {{--指定联系人联系情况--}}
                                <?php $contacts = $carrier->collection_contact;?>
                                @if($contacts)
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
                                        @foreach($contacts as $contact)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $contact['phone_num'] }}</td>
                                                <td>{{ $contact['contact_name'] }}</td>
                                                <td>{{ $contact['relationship'] }}</td>
                                                <td>{{ $contact['phone_num_loc'] ?: '暂无数据' }}</td>
                                                <td>{{ $contact['call_cnt'] }}</td>
                                                <td>{{ $contact['call_time'] }}</td>
                                                <td>{{ $contact['trans_start'] ?: '暂无数据' }}</td>
                                                <td>{{ $contact['trans_end'] ?: '暂无数据' }}</td>
                                                <td>{{ $contact['sms_cnt'] }}</td>
                                            </tr>
                                            @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
                                @endif
                                {{--用户信息检测--}}
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <?php $userInfoCheck = $carrier->user_info_check;?>
                                    @if($userInfoCheck)
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <h5>用户信息监测</h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>直接联系人中黑名单人数：</td>
                                            <td>{{ $userInfoCheck['contacts_class1_blacklist_cnt'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>间接联系人中黑名单人数：</td>
                                            <td>{{ $userInfoCheck['contacts_class2_blacklist_cnt'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>直接联系人人数：</td>
                                            <td>{{ $userInfoCheck['contacts_class1_cnt'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>引起间接黑名单人数：</td>
                                            <td>{{ $userInfoCheck['contacts_router_cnt'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>直接联系人中引起间接黑名单占比：</td>
                                            <td>{{ $userInfoCheck['contacts_router_ratio'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>查询过该用户的相关企业类型（姓名+身份证号+电话号码）：</td>
                                            <td>
                                                @if($userInfoCheck['searched_org_type'])
                                                    @foreach($userInfoCheck['searched_org_type'] as $type)
                                                        {{ \App\Constants\WandConstant::ORG_TYPE_MAP[$type] }} &nbsp;
                                                    @endforeach
                                                @else
                                                    暂无数据
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>身份证组合过的其他姓名：</td>
                                            <td>
                                                @if($userInfoCheck['idcard_with_other_names'])
                                                    @foreach($userInfoCheck['idcard_with_other_names'] as $name)
                                                        {{ $name  }} &nbsp;
                                                    @endforeach
                                                @else
                                                    暂无数据
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>身份证组合过的其他电话：</td>
                                            <td>
                                                @if($userInfoCheck['idcard_with_other_phones'])
                                                    @foreach($userInfoCheck['idcard_with_other_phones'] as $phone)
                                                        {{ $phone }} &nbsp;
                                                    @endforeach
                                                @else
                                                    暂无数据
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>电话号码组合过其他姓名：</td>
                                            <td>
                                                @if($userInfoCheck['phone_with_other_names'])
                                                    @foreach($userInfoCheck['phone_with_other_names'] as $name)
                                                        {{ $name }} &nbsp;
                                                    @endforeach
                                                @else
                                                    暂无数据
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>电话号码组合过其他身份证：</td>
                                            <td>
                                                @if($userInfoCheck['phone_with_other_idcards'])
                                                    @foreach($userInfoCheck['phone_with_other_idcards'] as $idcard)
                                                        {{ $idcard }} &nbsp;
                                                    @endforeach
                                                @else
                                                    暂无数据
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>电话号码注册过相关的企业数量：</td>
                                            <td>{{ $userInfoCheck['register_org_cnt'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>电话号码注册过相关的企业类型：</td>
                                            <td>
                                                @if($userInfoCheck['register_org_type'])
                                                    @foreach($userInfoCheck['register_org_type'] as $type)
                                                        {{ \App\Constants\WandConstant::ORG_TYPE_MAP[$type] }} &nbsp;
                                                    @endforeach
                                                @else
                                                    暂无数据
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>电话号码出现过的公开信息网站：</td>
                                            <td>
                                                @if($userInfoCheck['arised_open_web'])
                                                    @foreach($userInfoCheck['arised_open_web'] as $web)
                                                        {{ $web }} &nbsp;
                                                    @endforeach
                                                @else
                                                    暂无数据
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                {{--行为分析--}}
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <?php $cellBehaviors = $carrier->cell_behavior;?>
                                    @if($cellBehaviors)
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
                                        @foreach($cellBehaviors as $cellBehavior)
                                            <tr>
                                                <td>{{ $cellBehavior['cell_mth'] }}</td>
                                                <td>{{ $cellBehavior['total_amount'] }}</td>
                                                <td>{{ $cellBehavior['net_flow'] }}</td>
                                                <td>{{ $cellBehavior['cell_mth'] }}</td>
                                                <td>{{ $cellBehavior['call_cnt'] }}</td>
                                                <td>{{ $cellBehavior['call_time'] }}</td>
                                                <td>{{ $cellBehavior['dial_cnt'] }}</td>
                                                <td>{{ $cellBehavior['dial_time'] }}</td>
                                                <td>{{ $cellBehavior['dialed_cnt'] }}</td>
                                                <td>{{ $cellBehavior['dialed_time'] }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                                {{--充值记录--}}
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <?php $cellBehaviors = $carrier->cell_behavior;?>
                                    @if($cellBehaviors)
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
                                        @foreach($cellBehaviors as $cellBehavior)
                                            <tr>
                                                <td>{{ $cellBehavior['cell_mth'] }}</td>
                                                <td>{{ $cellBehavior['rechange_cnt'] }}</td>
                                                <td>{{ $cellBehavior['rechange_amount'] /100 }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td>合计</td>
                                            <td>{{ array_sum(array_column($cellBehaviors, 'rechange_cnt')) }}</td>
                                            <td>{{ array_sum(array_column($cellBehaviors, 'rechange_amount')) / 100 }}</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                {{--行为检测--}}
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <?php $behaviorCheck = $carrier->behavior_check;?>
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
                                        <td>{{ $behaviorCheck['regular_circle']['result'] }}</td>
                                        <td>{{ $behaviorCheck['regular_circle']['evidence'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>号码使用时间</td>
                                        <td>{{ $behaviorCheck['phone_used_time']['result'] }}</td>
                                        <td>{{ $behaviorCheck['phone_used_time']['evidence'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>手机静默情况</td>
                                        <td>{{ $behaviorCheck['phone_silent']['result'] }}</td>
                                        <td>{{ $behaviorCheck['phone_silent']['evidence'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>静默度</td>
                                        <td>{{ isset($order->userReport->silence_period) ? round($order->userReport->silence_period*100/180) .'%': '暂无数据' }}</td>
                                        <td>180天内无通话记录的时间占比</td>
                                    </tr>
                                    {{--<tr>--}}
                                        {{--<td>关机情况</td>--}}
                                        {{--<td>{{ $behaviorCheck['phone_power_off']['result'] }}</td>--}}
                                        {{--<td>{{ $behaviorCheck['phone_power_off']['evidence'] }}</td>--}}
                                    {{--</tr>--}}
                                    <tr>
                                        <td>互通电话的号码数量</td>
                                        <td>{{ $behaviorCheck['contact_each_other']['result'] }}</td>
                                        <td>{{ $behaviorCheck['contact_each_other']['evidence'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>与澳门地区电话通话情况</td>
                                        <td>{{ $behaviorCheck['contact_macao']['result'] }}</td>
                                        <td>{{ $behaviorCheck['contact_macao']['evidence'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>与110通话情况</td>
                                        <td>{{ $behaviorCheck['contact_110']['result'] }}</td>
                                        <td>{{ $behaviorCheck['contact_110']['evidence'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>与120通话情况</td>
                                        <td>{{ $behaviorCheck['contact_120']['result'] }}</td>
                                        <td>{{ $behaviorCheck['contact_120']['evidence'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>与律师通话情况</td>
                                        <td>{{ $behaviorCheck['contact_lawyer']['result'] }}</td>
                                        <td>{{ $behaviorCheck['contact_lawyer']['evidence'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>与法院通话情况</td>
                                        <td>{{ $behaviorCheck['contact_court']['result'] }}</td>
                                        <td>{{ $behaviorCheck['contact_court']['evidence'] }}</td>
                                    </tr><tr>
                                        <td>与贷款类号码联系情况</td>
                                        <td>{{ $behaviorCheck['contact_loan']['result'] }}</td>
                                        <td>{{ $behaviorCheck['contact_loan']['evidence'] }}</td>
                                    </tr><tr>
                                        <td>与银行类号码联系情况</td>
                                        <td>{{ $behaviorCheck['contact_bank']['result'] }}</td>
                                        <td>{{ $behaviorCheck['contact_bank']['evidence'] }}</td>
                                    </tr><tr>
                                        <td>与信用卡类号码联系情况</td>
                                        <td>{{ $behaviorCheck['contact_credit_card']['result'] }}</td>
                                        <td>{{ $behaviorCheck['contact_credit_card']['evidence'] }}</td>
                                    </tr><tr>
                                        <td>与催收类号码联系情况</td>
                                        <td>{{ $behaviorCheck['contact_collection']['result'] }}</td>
                                        <td>{{ $behaviorCheck['contact_collection']['evidence'] }}</td>
                                    </tr><tr>
                                        <td>夜间活动情况（0点-7点）</td>
                                        <td>{{ $behaviorCheck['contact_night']['result'] }}</td>
                                        <td>{{ $behaviorCheck['contact_night']['evidence'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>居住地本地（省份）地址在电商中使用时长</td>
                                        <td>{{ $behaviorCheck['dwell_used_time']['result'] }}</td>
                                        <td>{{ $behaviorCheck['dwell_used_time']['evidence'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>总体电商使用情况</td>
                                        <td>{{ $behaviorCheck['ebusiness_info']['result'] }}</td>
                                        <td>{{ $behaviorCheck['ebusiness_info']['evidence'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>申请人本人电商使用情况</td>
                                        <td>{{ $behaviorCheck['person_ebusiness_info']['result'] }}</td>
                                        <td>{{ $behaviorCheck['person_ebusiness_info']['evidence'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>虚拟商品购买情况</td>
                                        <td>{{ $behaviorCheck['virtual_buying']['result'] }}</td>
                                        <td>{{ $behaviorCheck['virtual_buying']['evidence'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>彩票购买情况</td>
                                        <td>{{ $behaviorCheck['lottery_buying']['result'] }}</td>
                                        <td>{{ $behaviorCheck['lottery_buying']['evidence'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>号码通话情况</td>
                                        <td>{{ $behaviorCheck['phone_call']['result'] }}</td>
                                        <td>{{ $behaviorCheck['phone_call']['evidence'] }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                {{--通话详单--}}
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <?php $callContactDetail = $carrier->call_contact_detail;?>
                                    @if($callContactDetail)
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
                                        @foreach($callContactDetail as $callContact)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $callContact['peer_num'] }}</td>
                                                <td>{{ $callContact['city'] }}</td>
                                                <td>{{ $callContact['company_name'] }}</td>
                                                <td>{{ $callContact['call_cnt_1w'] }}</td>
                                                <td>{{ $callContact['call_cnt_1m'] }}</td>
                                                <td>{{ $callContact['call_cnt_3m'] }}</td>
                                                <td>{{ $callContact['call_cnt_6m'] }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                                {{--联系人区域汇总--}}
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <?php $contactRegion = $carrier->contact_region;?>
                                    @if($contactRegion)
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
                                        @foreach($contactRegion as $value)
                                            <tr>
                                                <td>{{ $value['region_loc'] }}</td>
                                                <td>{{ $value['region_uniq_num_cnt'] }}</td>
                                                <td>{{ $value['region_call_cnt'] }}</td>
                                                <td>{{ $value['region_call_time'] }}</td>
                                                <td>{{ $value['region_dial_cnt'] }}</td>
                                                <td>{{ $value['region_dial_time'] }}</td>
                                                <td>{{ $value['region_dialed_cnt'] }}</td>
                                                <td>{{ $value['region_dialed_time'] }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                                {{--亲情号通话详单--}}
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <?php $callFamilyDetail = $carrier->call_family_detail;?>
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
                                        <td>{{ $userBasic['mobile'] }}</td>
                                        <td>{{ $callFamilyDetail['is_family_member'] }}</td>
                                        <td>{{ $callFamilyDetail['is_family_master'] }}</td>
                                        <td>{{ $callFamilyDetail['continue_recharge_month_cnt'] }}</td>
                                        <td>{{ $callFamilyDetail['is_address_match_attribution'] }}</td>
                                        <td>通话次数 小于 使用月数＊1次 :{{ $callFamilyDetail['is_address_match_attribution'] }}</td>
                                        <td>{{ $callFamilyDetail['unpaid_month_cnt'] }}</td>
                                        <td>{{ $callFamilyDetail['live_month_cnt'] }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                {{--亲情号通话汇总--}}
                                {{--<table class="table table-condensed table-hover" width="100%">--}}
                                {{--<tbody>--}}
                                {{--<tr>--}}
                                {{--<td colspan="4" class="text-center">--}}
                                {{--<h5>亲情号通话汇总</h5>--}}
                                {{--</td>--}}
                                {{--</tr>--}}
                                {{--<tr>--}}
                                {{--<td>周期</td>--}}
                                {{--<td>近一个月</td>--}}
                                {{--<td>近三个月</td>--}}
                                {{--<td>近六个月</td>--}}
                                {{--</tr>--}}
                                {{--<tr>--}}
                                {{--<td>通话数量</td>--}}
                                {{--<td>9</td>--}}
                                {{--<td>34</td>--}}
                                {{--<td>67</td>--}}
                                {{--</tr>--}}
                                {{--</tbody>--}}
                                {{--</table>--}}
                                {{--通话风险分析--}}
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <?php $callRiskAnalysis = $carrier->call_risk_analysis;?>
                                    @if($callRiskAnalysis)
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <h5>通话风险分析</h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>通话类型</td>
                                            <td>分析描述</td>
                                        </tr>
                                        @foreach($callRiskAnalysis as $key => $analysis)
                                            <tr>
                                                <td>{{ $key }}</td>
                                                <td>
                                                    {{--1个月--}}
                                                    近1个月通话总次数{{ $analysis['call_cnt_1m'] }}
                                                    近1个月通话总时长{{ $analysis['call_cnt_1m'] }}
                                                    近1个月主叫通话次数{{ $analysis['call_analysis_dial_point']['call_dial_cnt_1m'] }}
                                                    近1个月主叫通话总时长{{ $analysis['call_analysis_dial_point']['call_dial_time_1m'] }}
                                                    近1个月被叫通话次数{{ $analysis['call_analysis_dialed_point']['call_dialed_cnt_1m'] }}
                                                    近1个月被叫通话总时长{{ $analysis['call_analysis_dialed_point']['call_dialed_time_1m'] }} <br>
                                                    {{--3个月--}}
                                                    近3个月通话总次数{{ $analysis['call_cnt_3m'] }}
                                                    近3个月通话总时长{{ $analysis['call_cnt_3m'] }}
                                                    近3个月主叫通话次数{{ $analysis['call_analysis_dial_point']['call_dial_cnt_3m'] }}
                                                    近3个月主叫通话总时长{{ $analysis['call_analysis_dial_point']['call_dial_time_3m'] }}
                                                    近3个月被叫通话次数{{ $analysis['call_analysis_dialed_point']['call_dialed_cnt_3m'] }}
                                                    近3个月被叫通话总时长{{ $analysis['call_analysis_dialed_point']['call_dialed_time_3m'] }} <br>
                                                    {{--6个月--}}
                                                    近6个月通话总次数{{ $analysis['call_cnt_6m'] }}
                                                    近6个月通话总时长{{ $analysis['call_cnt_6m'] }}
                                                    近6个月主叫通话次数{{ $analysis['call_analysis_dial_point']['call_dial_cnt_6m'] }}
                                                    近6个月主叫通话总时长{{ $analysis['call_analysis_dial_point']['call_dial_time_6m'] }}
                                                    近6个月被叫通话次数{{ $analysis['call_analysis_dialed_point']['call_dialed_cnt_6m'] }}
                                                    近6个月被叫通话总时长{{ $analysis['call_analysis_dialed_point']['call_dialed_time_6m'] }} <br>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            @else
                                暂无数据
                            @endif
                        </div>
                    </div>
                    <div id="tab-4" class="tab-pane">
                        <div class="panel-body">
                            @if(!empty($taobaoInfo))
                                <?php $ecommerceBaseInfo = $taobaoInfo->ecommerce_base_info;?>
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>基本信息</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">淘宝昵称</label></td>
                                        <td>{{ $ecommerceBaseInfo['taobaoAccount'] }}</td>
                                        <td><label class="control-label">绑定微博账号</label></td>
                                        <td>{{ $ecommerceBaseInfo['weiboAccount'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">姓名</label></td>
                                        <td>{{ $ecommerceBaseInfo['name'] }}</td>
                                        <td><label class="control-label">绑定微博昵称</label></td>
                                        <td>{{ $ecommerceBaseInfo['weiboNickName'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">电话号码</label></td>
                                        <td>{{ $ecommerceBaseInfo['mobile'] }}</td>
                                        <td><label class="control-label">首次交易时间</label></td>
                                        <td>{{ $ecommerceBaseInfo['alipayRegistrationDatetime'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">绑定邮箱</label></td>
                                        <td>{{ $ecommerceBaseInfo['email'] ?: '暂无数据' }}</td>
                                        <td><label class="control-label">绑定支付宝账号</label></td>
                                        <td>{{ $ecommerceBaseInfo['alipayAccount'] ?? '暂无数据' }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <?php $ecommerceConsigneeAddresses = $taobaoInfo->ecommerce_consignee_addresses;?>
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
                                    @if(!empty($ecommerceConsigneeAddresses))
                                        @foreach($ecommerceConsigneeAddresses as $ecommerceConsigneeAddress)
                                            <tr>
                                                <td>{{ $ecommerceConsigneeAddress['receiveName'] ?? '暂无数据' }}</td>
                                                <td>{{ $ecommerceConsigneeAddress['telNumber'] }}</td>
                                                <td>{{ $ecommerceConsigneeAddress['postCode'] ?? '暂无数据' }}</td>
                                                <td>{{ ($ecommerceConsigneeAddress['region'] ?? '') . $ecommerceConsigneeAddress['address'] }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                暂无数据
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                <?php $taobaoOrders = $taobaoInfo->taobao_orders;
                                foreach ($taobaoOrders as &$taobaoOrder) {
                                    $taobaoOrder['createTime'] = strtotime($taobaoOrder['createTime']);
                                }
                                unset($taobaoOrder);
                                array_multisort(array_column($taobaoOrders, 'createTime'), SORT_DESC, $taobaoOrders);
                                $lastTaobaoOrder = $taobaoOrders[0] ?? [];
                                ?>
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
                                    @if(!empty($lastTaobaoOrder))
                                        <tr>
                                            <td>{{ date('Y-m-d H:i:s', $lastTaobaoOrder['createTime']) ?? '暂无数据' }}</td>
                                            <td>{{ $lastTaobaoOrder['address']['receiveName'] ?? '暂无数据' }}</td>
                                            <td>{{ $lastTaobaoOrder['address']['address'] ?? '暂无数据' }}</td>
                                            <td>{{ $lastTaobaoOrder['address']['telNumber'] ?? '暂无数据' }}</td>
                                            <td>{{ $lastTaobaoOrder['address']['postCode'] ?? '暂无数据' }}</td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                暂无数据
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                <?php $lastSixMonthTimestamp = mktime(date('H'), date('i'), date('s'), date('m')-6, date('d'), date('Y'));
                                $lastSixMonthOrders = [];
                                foreach ($taobaoOrders as $taobaoOrder) {
                                    if ($taobaoOrder['createTime'] > $lastSixMonthTimestamp) {
                                        $lastSixMonthOrders[] = $taobaoOrder;
                                    }
                                }
                                ?>
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
                                    @if(!empty($lastSixMonthOrders))
                                        <?php $actualCount = 0; $lastSixMonthOrdersSuccess = 0; ?>
                                        @foreach($lastSixMonthOrders as $orderItem)
                                            <tr>
                                                <td>{{ date('Y-m-d H:i:s', $orderItem['createTime']) }}</td>
                                                <td>{{ $orderItem['orderNumber'] }}</td>
                                                <td>{{ $orderItem['seller']['shopName'] ?? '暂无数据' }}</td>
                                                <td>{{ $orderItem['seller']['nick'] }}</td>
                                                <td>
                                                    @if(count($orderItem['subOrders']) > 1)
                                                        <?php if (isset($orderItem['tradeStatusName']) && $orderItem['tradeStatusName'] == '成功') {
                                                            $lastSixMonthOrdersSuccess += 1;
                                                            $actualCount += $orderItem['subOrders'][1]['actual'];
                                                        } ?>
                                                        {{ $orderItem['subOrders'][1]['actual'] }}
                                                    @else
                                                        <?php if (isset($orderItem['tradeStatusName']) && $orderItem['tradeStatusName'] == '成功') {
                                                            $lastSixMonthOrdersSuccess += 1;
                                                            $actualCount += $orderItem['subOrders'][0]['actual'];
                                                        } ?>
                                                        {{ $orderItem['subOrders'][0]['actual'] }}
                                                    @endif
                                                </td>
                                                <td>{{ $orderItem['tradeTypeName'] ?? '暂无数据' }}</td>
                                                <td>{{ $orderItem['tradeStatusName'] ?? '暂无数据' }}</td>
                                            </tr>
                                        @endforeach
                                        @if($actualCount)
                                            <tr>
                                                <td><label class="control-label">合计笔数(成功的交易为准)</label></td>
                                                <td colspan="2">{{ $lastSixMonthOrdersSuccess }}笔</td>
                                                <td><label class="control-label">合计金额</label></td>
                                                <td colspan="3">{{ $actualCount }}</td>
                                            </tr>
                                        @endif
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                暂无数据
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            @else
                                暂无数据
                            @endif
                        </div>
                    </div>
                    <div id="tab-5" class="tab-pane">
                        <div class="panel-body">
                            @if(!empty($taobaoInfo))
                                <?php
                                $huabeiInfo = $taobaoInfo->huabei_info;
                                $jiebeiInfo = $taobaoInfo->jiebei_info;
                                $ecommerceBindedBankCards = $taobaoInfo->ecommerce_binded_bank_cards;
                                $ecommerceTrades = $taobaoInfo->ecommerce_trades;
                                ?>
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>基本信息</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">姓名</label></td>
                                        <td>{{ $ecommerceBaseInfo['name'] }}</td>
                                        <td><label class="control-label">支付宝注册时间</label></td>
                                        <td>{{ $ecommerceBaseInfo['alipayRegistrationDatetime'] ?? '暂无数据' }}</td>
                                        {{--<td colspan="2"><label class="control-label">性别</label></td>--}}
                                        {{--<td>无此数据-----？？？</td>--}}
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">邮箱</label></td>
                                        <td>{{ $ecommerceBaseInfo['email'] ?: '暂无数据' }}</td>
                                        <td><label class="control-label">手机号</label></td>
                                        <td>{{ $ecommerceBaseInfo['mobile'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">身份证号</label></td>
                                        <td>{{ $ecommerceBaseInfo['identityCard'] ?? '暂无数据' }}</td>
                                        <td><label class="control-label">是否实名认证</label></td>
                                        <td>{{ $ecommerceBaseInfo['isVerified'] ? '是' : '否' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">淘宝会员名</label></td>
                                        <td>{{ $ecommerceBaseInfo['taobaoAccount'] }}</td>
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
                                        <td>{{ $ecommerceBaseInfo['alipayBalance'] . '元' }}</td>
                                        <td><label class="control-label">余额宝</label></td>
                                        <td>{{ isset($ecommerceBaseInfo['yuebaoBalance']) ? $ecommerceBaseInfo['yuebaoBalance'] . '元' : '暂无数据' }}</td>
                                    </tr>
                                    {{--<tr>--}}
                                    {{--<td><label class="control-label">存金宝</label></td>--}}
                                    {{--<td>无此数据-----？？？</td>--}}
                                    {{--<td><label class="control-label">淘宝理财</label></td>--}}
                                    {{--<td>无此数据-----？？？</td>--}}
                                    {{--</tr>--}}
                                    {{--<tr>--}}
                                    {{--<td><label class="control-label">招财宝</label></td>--}}
                                    {{--<td>无此数据-----？？？</td>--}}
                                    {{--<td><label class="control-label">基金</label></td>--}}
                                    {{--<td>无此数据-----？？？</td>--}}
                                    {{--</tr>--}}
                                    <tr>
                                        <td><label class="control-label">花呗额度</label></td>
                                        <td>{{ (isset($huabeiInfo['huabeiAmount']) && !empty($huabeiInfo['huabeiAmount'])) ? $huabeiInfo['huabeiAmount'] . '元' : '暂无数据' }}</td>
                                        <td><label class="control-label">借呗额度</label></td>
                                        <td>{{ (isset($jiebeiInfo['jiebeiAmount']) && !empty($jiebeiInfo['jiebeiAmount'])) ? $jiebeiInfo['jiebeiAmount'] . '元' : '暂无数据' }}</td>
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
                                    @if(!empty($ecommerceBindedBankCards))
                                        <?php $bankCardTypeMap = [
                                            '1' => '借记卡',
                                            '2' => '信用卡'
                                        ]; ?>
                                        @foreach($ecommerceBindedBankCards as $ecommerceBindedBankCard)
                                            <tr>
                                                <td>{{ $ecommerceBindedBankCard['bankName'] .' '. $bankCardTypeMap[$ecommerceBindedBankCard['cardType']] }}</td>
                                                <td>{{ $ecommerceBindedBankCard['cardFullNumber'] ?? '暂无数据' }}</td>
                                                <td>{{ $ecommerceBindedBankCard['cardOwnerName'] ?? '暂无数据' }}</td>
                                                <td>{{ $ecommerceBindedBankCard['mobile'] ?? '暂无数据' }}</td>
                                                <td>{{ $ecommerceBindedBankCard['applyTime'] ?? '暂无数据' }}</td>
                                                <td>{{ $ecommerceBindedBankCard['isExpress'] ? '是' : '否' }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">暂无数据</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                <?php
                                $huabeiEcommerceTrades = [];
                                $huabeiEcommerceTradesSuccess = [];
                                $bankCardEcommerceTrades = [];
                                $bankCardEcommerceTradesSuccess = [];
                                $repayCertifyCardEcommerceTrades = [];
                                $repayCertifyCardEcommerceTradesSuccess = [];
                                $repayHuabeiEcommerceTrades = [];
                                $repayHuabeiEcommerceTradesSuccess = [];
                                $repayJiebeiEcommerceTrades = [];
                                $repayJiebeiEcommerceTradesSuccess = [];

                                foreach ($ecommerceTrades as $ecommerceTrade) {
                                    if (isset($ecommerceTrade['payType']) && $ecommerceTrade['payType'] == \App\Constants\CertifyTaobaoConstant::PAYTYPE_BANKCARD) {
                                        //处理交易记录中 近半年的银行卡交易记录
                                        $bankCardEcommerceTrades[] = $ecommerceTrade;
                                        if ($ecommerceTrade['tradeStatusName'] == '成功') {
                                            $bankCardEcommerceTradesSuccess[] = $ecommerceTrade;
                                        }
                                    } elseif (isset($ecommerceTrade['txTypeId']) && $ecommerceTrade['txTypeId'] == \App\Constants\CertifyTaobaoConstant::TXTYPEDID_REPAY_CERTIFYCARD) {
                                        //处理交易记录中 近半年的信用卡还款记录
                                        $repayCertifyCardEcommerceTrades[] = $ecommerceTrade;
                                        if ($ecommerceTrade['tradeStatusName'] == '成功') {
                                            $repayCertifyCardEcommerceTradesSuccess[] = $ecommerceTrade;
                                        }
                                    } elseif (isset($ecommerceTrade['txTypeId']) && $ecommerceTrade['txTypeId'] == \App\Constants\CertifyTaobaoConstant::TXTYPEDID_REPAY_FEIJIETIAO && isset($ecommerceTrade['otherSide'])) {
                                        // 非借条还款
                                        if ($ecommerceTrade['otherSide'] == '蚂蚁花呗' || $ecommerceTrade['otherSide'] == '花呗') {
                                            $repayHuabeiEcommerceTrades[] = $ecommerceTrade;
                                            if ($ecommerceTrade['tradeStatusName'] == '成功') {
                                                $repayHuabeiEcommerceTradesSuccess[] = $ecommerceTrade;
                                            }
                                        } elseif ($ecommerceTrade['otherSide'] == '蚂蚁借呗' || $ecommerceTrade['otherSide'] == '借呗') {
                                            $repayJiebeiEcommerceTrades[] = $ecommerceTrade;
                                            if ($ecommerceTrade['tradeStatusName'] == '成功') {
                                                $repayJiebeiEcommerceTradesSuccess[] = $ecommerceTrade;
                                            }
                                        }
                                    } elseif (isset($ecommerceTrade['payType']) && $ecommerceTrade['payType'] == \App\Constants\CertifyTaobaoConstant::PAYTYPE_HUABEI) {
                                        $huabeiEcommerceTrades[] = $ecommerceTrade;
                                        if ($ecommerceTrade['tradeStatusName'] == '成功') {
                                            $huabeiEcommerceTradesSuccess[] = $ecommerceTrade;
                                        }
                                    }
                                }
                                ?>
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
                                    @if(!empty($huabeiEcommerceTrades))
                                        @foreach($huabeiEcommerceTrades as $huabeiEcommerceTrade)
                                            <tr>
                                                <td>{{ $huabeiEcommerceTrade['tradeTime'] }}</td>
                                                <td>{{ $huabeiEcommerceTrade['txTypeName'] ?? '暂无数据' }}</td>
                                                <td>花呗</td>
                                                <td>{{ $huabeiEcommerceTrade['tradeStatusName'] ?? '暂无数据' }}</td>
                                                <td>{{ $huabeiEcommerceTrade['amount'] }}</td>
                                                <td>{{ $huabeiEcommerceTrade['title'] }}</td>
                                            </tr>
                                        @endforeach
                                        @if(!empty($huabeiEcommerceTradesSuccess))
                                            <tr>
                                                <td><label class="control-label">合计笔数(成功的交易为准)</label></td>
                                                <td colspan="2">{{ count($huabeiEcommerceTradesSuccess) }}笔</td>
                                                <td><label class="control-label">合计金额</label></td>
                                                <td colspan="2">{{ array_sum(array_column($huabeiEcommerceTradesSuccess, 'amount')) }}</td>
                                            </tr>
                                        @endif
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">暂无数据</td>
                                        </tr>
                                    @endif
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
                                    @if(!empty($bankCardEcommerceTrades))
                                        @foreach($bankCardEcommerceTrades as $bankCardEcommerceTrade)
                                            <tr>
                                                <td>{{ $bankCardEcommerceTrade['tradeTime'] }}</td>
                                                <td>{{ $bankCardEcommerceTrade['txTypeName'] ?? '暂无数据' }}</td>
                                                <td>银行卡</td>
                                                <td>{{ $bankCardEcommerceTrade['tradeStatusName'] ?? '暂无数据' }}</td>
                                                <td>{{ $bankCardEcommerceTrade['amount'] }}</td>
                                                <td>{{ $bankCardEcommerceTrade['title'] }}</td>
                                            </tr>
                                        @endforeach
                                        @if(!empty($bankCardEcommerceTradesSuccess))
                                            <tr>
                                                <td><label class="control-label">合计笔数(成功的交易为准)</label></td>
                                                <td colspan="2">{{ count($bankCardEcommerceTradesSuccess) }}笔</td>
                                                <td><label class="control-label">合计金额</label></td>
                                                <td colspan="2">{{ array_sum(array_column($bankCardEcommerceTradesSuccess, 'amount')) }}</td>
                                            </tr>
                                        @endif
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">暂无数据</td>
                                        </tr>
                                    @endif
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
                                    @if(!empty($repayCertifyCardEcommerceTrades))
                                        @foreach($repayCertifyCardEcommerceTrades as $repayCertifyCardEcommerceTrade)
                                            <tr>
                                                <td>{{ $repayCertifyCardEcommerceTrade['tradeTime'] }}</td>
                                                <td>{{ $repayCertifyCardEcommerceTrade['tradeNo'] }}</td>
                                                <td>{{ $repayCertifyCardEcommerceTrade['tradeStatusName'] ?? '暂无数据' }}</td>
                                                <td>{{ $repayCertifyCardEcommerceTrade['amount'] }}</td>
                                            </tr>
                                        @endforeach
                                        @if(!empty($repayCertifyCardEcommerceTradesSuccess))
                                            <tr>
                                                <td><label class="control-label">合计笔数(成功的交易为准)</label></td>
                                                <td>{{ count($repayCertifyCardEcommerceTradesSuccess) }}笔</td>
                                                <td><label class="control-label">合计金额</label></td>
                                                <td>{{ array_sum(array_column($repayCertifyCardEcommerceTradesSuccess, 'amount')) }}</td>
                                            </tr>
                                        @endif
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center">暂无数据</td>
                                        </tr>
                                    @endif
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
                                        <td>{{ (isset($huabeiInfo['huabeiAmount']) && !empty($huabeiInfo['huabeiAmount'])) ? $huabeiInfo['huabeiAmount'] . '元' : '暂无数据' }}</td>
                                        <td><label class="control-label">花呗是否逾期</label></td>
                                        <td>
                                            @if(isset($huabeiInfo['huabeiStatus']) && $huabeiInfo['huabeiStatus'] != 0)
                                                逾期
                                            @else
                                                未逾期
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">未还款期数</label></td>
                                        <td>{{ $huabeiInfo['huabeiOverdueBillCnt'] ?? '暂无数据' }}</td>
                                        <td><label class="control-label">未还款总金额</label></td>
                                        <td>暂无数据</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">逾期天数</label></td>
                                        <td>{{ $huabeiInfo['huabeiOverdueDays'] ?? '暂无数据' }}</td>
                                        <td><label class="control-label">罚息</label></td>
                                        <td>{{ $huabeiInfo['huabeiPenaltyAmount'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">当月还款额</label></td>
                                        <td>{{ $huabeiInfo['huabeiCurrentMonthPayment'] ?? '暂无数据' }}</td>
                                        <td><label class="control-label">下月还款额度</label></td>
                                        <td>{{ $huabeiInfo['huabeiNextMonthPayment'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr class="trbg">
                                        <td><label class="control-label">还款时间</label></td>
                                        <td><label class="control-label">交易号</label></td>
                                        <td><label class="control-label">交易状态</label></td>
                                        <td><label class="control-label">金额(元)</label></td>
                                    </tr>
                                    @if(!empty($repayHuabeiEcommerceTrades))
                                        @foreach($repayHuabeiEcommerceTrades as $repayHuabeiEcommerceTrade)
                                            <tr>
                                                <td>{{ $repayHuabeiEcommerceTrade['tradeTime'] }}</td>
                                                <td>{{ $repayHuabeiEcommerceTrade['tradeNo'] }}</td>
                                                <td>{{ $repayHuabeiEcommerceTrade['tradeStatusName'] ?? '暂无数据' }}</td>
                                                <td>{{ $repayHuabeiEcommerceTrade['amount'] }}</td>
                                            </tr>
                                        @endforeach
                                        @if(!empty($repayHuabeiEcommerceTradesSuccess))
                                            <tr>
                                                <td><label class="control-label">合计笔数(成功的交易为准)</label></td>
                                                <td>{{ count($repayHuabeiEcommerceTradesSuccess) }}笔</td>
                                                <td><label class="control-label">合计金额</label></td>
                                                <td>{{ array_sum(array_column($repayHuabeiEcommerceTradesSuccess, 'amount')) }}</td>
                                            </tr>
                                        @endif
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center">暂无数据</td>
                                        </tr>
                                    @endif
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
                                        <td>{{ $jiebeiInfo['jiebeiAmount'] ?? '暂无数据' }}</td>
                                        <td><label class="control-label">借呗是否逾期</label></td>
                                        <td>
                                            @if(isset($jiebeiInfo['jiebeiOvdAble']) && $jiebeiInfo['jiebeiOvdAble'] == 1)
                                                是
                                            @else
                                                否
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">未还期数</label></td>
                                        <td>{{ $jiebeiInfo['jiebeiUnClearLoanCount'] ?? '暂无数据' }}</td>
                                        <td><label class="control-label">未还总金额</label></td>
                                        <td>暂无数据</td>
                                    </tr>
                                    <tr class="trbg">
                                        <td><label class="control-label">还款时间</label></td>
                                        <td><label class="control-label">交易号</label></td>
                                        <td><label class="control-label">交易状态</label></td>
                                        <td><label class="control-label">金额(元)</label></td>
                                    </tr>
                                    @if(!empty($repayJiebeiEcommerceTrades))
                                        @foreach($repayJiebeiEcommerceTrades as $repayJiebeiEcommerceTrade)
                                            <tr>
                                                <td>{{ $repayJiebeiEcommerceTrade['tradeTime'] }}</td>
                                                <td>{{ $repayJiebeiEcommerceTrade['tradeNo'] }}</td>
                                                <td>{{ $repayJiebeiEcommerceTrade['tradeStatusName'] ?? '暂无数据' }}</td>
                                                <td>{{ $repayJiebeiEcommerceTrade['amount'] }}</td>
                                            </tr>
                                        @endforeach
                                        @if(!empty($repayJiebeiEcommerceTradesSuccess))
                                            <tr>
                                                <td><label class="control-label">合计笔数(成功的交易为准)</label></td>
                                                <td>{{ count($repayJiebeiEcommerceTradesSuccess) }}笔</td>
                                                <td><label class="control-label">合计金额</label></td>
                                                <td>{{ array_sum(array_column($repayJiebeiEcommerceTradesSuccess, 'amount')) }}</td>
                                            </tr>
                                        @endif
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center">暂无数据</td>
                                        </tr>
                                    @endif
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
                                    @if(!empty($ecommerceTrades))
                                        <?php
                                        $ecommerceTradesSuccess = [];
                                        foreach ($ecommerceTrades as $ecommerceTrade) {
                                            if ($ecommerceTrade['tradeStatusName'] == '成功') {
                                                $ecommerceTradesSuccess[] = $ecommerceTrade;
                                            }
                                        }
                                        ?>
                                        @foreach($ecommerceTrades as $ecommerceTrade)
                                            <tr>
                                                <td>{{ $ecommerceTrade['tradeTime'] }}</td>
                                                <td>{{ $ecommerceTrade['txTypeName'] ?? '暂无数据' }}</td>
                                                <td>{{ $ecommerceTrade['otherSide'] ?? '暂无数据' }}</td>
                                                <td>{{ $ecommerceTrade['title'] }}</td>
                                                <td>{{ $ecommerceTrade['amount'] ? $ecommerceTrade['amount'] : '暂无数据' }}</td>
                                                <td>{{ $ecommerceTrade['tradeStatusName'] ?? '暂无数据' }}</td>
                                            </tr>
                                        @endforeach
                                        @if(!empty($ecommerceTradesSuccess))
                                            <tr>
                                                <td colspan="2"><label class="control-label">合计笔数(成功的交易为准)</label></td>
                                                <td>{{ count($ecommerceTradesSuccess) }}笔</td>
                                                <td><label class="control-label">合计金额</label></td>
                                                <td colspan="2">{{ array_sum(array_column($ecommerceTradesSuccess, 'amount')) }}</td>
                                            </tr>
                                        @endif
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">暂无数据</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            @else
                                暂无数据
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane fade" id="multilateral-lending">
                        <div class="panel-body">
                            <?php $multilateralLending = App\Models\Orm\CertifyMultilateralLending::where('id', $order->userReport->multilateral_lending_id)->first(); ?>
                            @if($multilateralLending)
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <h5>贷款履约行为评估</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>姓名:{{ $basicInfo['name'] ?? ($userBasic['name'] ?? '暂无数据') }}</td>
                                        <td>身份证号:{{ $basicInfo['id_card'] ?? ($userBasic['id_card'] ?? '暂无数据') }}</td>
                                        <td>查询日期:{{ $assignedAt }}</td>
                                    </tr>
                                    <tr class="trbg">
                                        <td colspan="2">评估项目</td>
                                        <td colspan="2">评估结果</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">贷款行为分</td>
                                        <td colspan="2">{{ $multilateralLending->result_detail['loans_score'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">贷款行为置信度</td>
                                        <td colspan="2">{{ $multilateralLending->result_detail['loans_credibility'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">贷款放款总订单数</td>
                                        <td colspan="2">{{ $multilateralLending->result_detail['loans_count'] ?? '暂无数据' }} </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">贷款已结清订单数</td>
                                        <td colspan="2">{{ $multilateralLending->result_detail['loans_settle_count'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">贷款逾期订单数(M0+)</td>
                                        <td colspan="2">{{ $multilateralLending->result_detail['loans_overdue_count'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">贷款机构数</td>
                                        <td colspan="2">{{ $multilateralLending->result_detail['loans_org_count'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">消费金融类机构数</td>
                                        <td colspan="2">{{ $multilateralLending->result_detail['consfin_org_count'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">网络贷款类机构数</td>
                                        <td colspan="2">{{ $multilateralLending->result_detail['loans_cash_count'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">近1月贷款笔数</td>
                                        <td colspan="2">{{ $multilateralLending->result_detail['latest_one_month'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">近3月贷款笔数</td>
                                        <td colspan="2">{{ $multilateralLending->result_detail['latest_three_month'] ?? '暂无数据' }}</td>
                                    </tr><tr>
                                        <td colspan="2">近6月贷款笔数</td>
                                        <td colspan="2">{{ $multilateralLending->result_detail['latest_six_month'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">最近一次贷款时间</td>
                                        <td colspan="2">{{ $multilateralLending->result_detail['loans_latest_time'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">信用贷款时长</td>
                                        <td colspan="2">{{ $multilateralLending->result_detail['loans_long_time'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">历史贷款机构成功扣款笔数</td>
                                        <td colspan="2">{{ $multilateralLending->result_detail['history_suc_fee'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">历史贷款机构失败扣款笔数</td>
                                        <td colspan="2">{{ $multilateralLending->result_detail['history_fail_fee'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">近1月贷款机构成功扣款笔数</td>
                                        <td colspan="2">{{ $multilateralLending->result_detail['latest_one_month_suc'] ?? '暂无数据' }}</td>
                                    </tr><tr>
                                        <td colspan="2">近1月贷款机构失败扣款笔数</td>
                                        <td colspan="2">{{ $multilateralLending->result_detail['latest_one_month_fail'] ?? '暂无数据' }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <br>
                                <span>
                                    特别说明：<br>
                                    1.贷款行为分/置信度: 新颜征信综合自身海量用户的历史贷款数据，利用机器学习的方法构建贷款行为动态评估模型，并由此计算出用户的贷款行为分及置信 度。 其中，贷款行为分是对该用户历史贷款行为的综合评估，取值范围1-1000分;置信度是对贷款行为分的结果可靠程度的评估，取值范围50-100分。
                                </span>
                            @else
                                暂无数据
                            @endif
                        </div>
                    </div>
                    {{-- 借条平台 --}}
                    <div class="tab-pane fade" id="iou-platform">
                        <div class="panel-body">
                            @if($order->UserReport->iou_platform_id)
                                <?php $iouPlatformInfo = \App\Models\Orm\CertifyIouPlatform::find($order->UserReport->iou_platform_id); ?>
                                <table class="table table-condensed table-hover" width="100%">
                                    <tbody>
                                    <tr>
                                        <td><label class="control-label">姓名：</label></td>
                                        <td>{{ $basicInfo['name'] ?? ($userBasic['name'] ?? '暂无数据') }}</td>
                                        <td><label class="control-label">身份证号码：</label></td>
                                        <td>{{ $basicInfo['id_card'] ?? ($userBasic['id_card'] ?? '暂无数据') }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">性别：</label></td>
                                        <td>{{ $userBasic['gender'] ?? '暂无数据' }}</td>
                                        <td><label class="control-label">年龄：</label></td>
                                        <td>{{ $userBasic['age'] ?? '暂无数据' }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                @if($iouPlatformInfo->jiedaibao_info)
                                    <table class="table table-condensed table-hover" width="100%">
                                        <tbody>
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <h5>借XX</h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label class="control-label">是否高风险用户：</label></td>
                                            <td>{{ $iouPlatformInfo->jiedaibao_info['is_high_risk_user'] ?? '0' }}</td>
                                            <td><label class="control-label">最近一次访问日期：</label></td>
                                            <td>{{ $iouPlatformInfo->jiedaibao_info['last_visit_dt'] ?? '暂无数据' }}</td>
                                        </tr>
                                        <tr>
                                            <td><label class="control-label">30天以上逾期次数：</label></td>
                                            <td>{{ isset($iouPlatformInfo->jiedaibao_info['30d_overdue_cnt']) ? $iouPlatformInfo->jiedaibao_info['30d_overdue_cnt'] : '0' }}</td>
                                            <td><label class="control-label">历史逾期金额：</label></td>
                                            <td>{{ $iouPlatformInfo->jiedaibao_info['his_overdue_amt'] ?? '0'  }}</td>
                                        </tr>
                                        <tr>
                                            <td><label class="control-label">最近一次逾期时间：</label></td>
                                            <td>{{ $iouPlatformInfo->jiedaibao_info['last_overdue_dt'] ?? '0'  }}</td>
                                            <td><label class="control-label">最近一次逾期金额：</label></td>
                                            <td>{{ $iouPlatformInfo->jiedaibao_info['his_overdue_amt'] ?? '0'  }}</td>
                                        </tr>
                                        <tr>
                                            <td><label class="control-label">当前逾期金额：</label></td>
                                            <td>{{ $iouPlatformInfo->jiedaibao_info['curr_overdue_amt'] ?? '0'  }}</td>
                                            <td><label class="control-label">当前逾期最大天数：</label></td>
                                            <td>{{ $iouPlatformInfo->jiedaibao_info['curr_overdue_days'] ?? '0'  }}</td>
                                        </tr>
                                        <tr>
                                            <td><label class="control-label">首次逾期时间：</label></td>
                                            <td>{{ $iouPlatformInfo->jiedaibao_info['first_overdue_dt'] ?? '0'  }}</td>
                                            <td><label class="control-label">首次逾期金额：</label></td>
                                            <td>{{ $iouPlatformInfo->jiedaibao_info['first_overdue_amt'] ?? '0'  }}</td>
                                        </tr>
                                        <tr>
                                            <td><label class="control-label">最近一次还款时间：</label></td>
                                            <td>{{ $iouPlatformInfo->jiedaibao_info['last_repay_tm'] ?? '0'  }}</td>
                                            <td><label class="control-label">总还款次数：</label></td>
                                            <td>{{ $iouPlatformInfo->jiedaibao_info['repay_times'] ?? '0'  }}</td>
                                        </tr>
                                        <tr>
                                            <td><label class="control-label">正在进行的贷款笔数：</label></td>
                                            <td>{{ $iouPlatformInfo->jiedaibao_info['curr_debt_product_cnt'] ?? '0'  }}</td>
                                            <td><label class="control-label">历史贷款笔数：</label></td>
                                            <td>{{ $iouPlatformInfo->jiedaibao_info['total_in_order_cnt'] ?? '0'  }}</td>
                                        </tr>
                                        <tr>
                                            <td><label class="control-label">历史总借款金额：</label></td>
                                            <td>{{ $iouPlatformInfo->jiedaibao_info['curr_debt_product_cnt'] ?? '0'  }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                @else
                                    暂无数据
                                @endif
                            @else
                                暂无数据
                            @endif
                        </div>
                    </div>
                    <div id="tab-6" class="tab-pane">
                        <div class="panel-body">
                            @if($order->UserReport->wand_id)
                                <?php $orgTyepMap = \App\Constants\WandConstant::ORG_TYPE_MAP; ?>
                                <?php $wandInfo = \App\Models\Factory\Admin\Order\CertifyWandFactory::getById($order->UserReport->wand_id); ?>
                                <table class="table table-condensed table-hover" width="100%">
                                    <?php $personInfo = $wandInfo->person_info; ?>
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>基本信息</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">姓名：</label></td>
                                        <td>{{ $personInfo['name'] }}</td>
                                        <td><label class="control-label">身份证号码：</label></td>
                                        <td>{{ $personInfo['idcard'] }} 有效</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">性别：</label></td>
                                        <td>{{ $personInfo['gender'] }}</td>
                                        <td><label class="control-label">年龄：</label></td>
                                        <td>{{ $personInfo['age'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">身份证归属地：</label></td>
                                        <td>{{ $personInfo['idcard_location'] }}</td>
                                        <td><label class="control-label">运营商 ：</label></td>
                                        <td>{{ $personInfo['carrier'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">手机号码归属地：</label></td>
                                        <td>{{ $personInfo['mobile_location'] }}</td>
                                        <td><label class="control-label">邮箱 ：</label></td>
                                        <td>{{ $personInfo['email'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">所在单位：</label></td>
                                        <td>{{ $personInfo['company'] ?? '暂无数据' }}</td>
                                        <td><label class="control-label">单位类型 ：</label></td>
                                        <td>{{ $personInfo['company_type'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">家庭住址：</label></td>
                                        <td colspan="3">{{ $personInfo['home_address'] ?? '暂无数据' }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <?php $verifInfo = $wandInfo->verification_info; ?>
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>基本信息校验</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">是否导入运营商数据：</label></td>
                                        <td>{{ $verifInfo['has_carrier_data'] ? '是' : '否' }}</td>
                                        <td><label class="control-label">是否导入公积金数据：</label></td>
                                        <td>{{ $verifInfo['has_fund_data'] ? '是' : '否' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">是否导入网银数据：</label></td>
                                        <td>{{ $verifInfo['has_onlinebank_data'] ? '是' : '否' }}</td>
                                        <td><label class="control-label">身份证号码是否与公积金数据匹配：</label></td>
                                        <td>{{ isset($verifInfo['idcard_match_fund']) ? ($verifInfo['idcard_match_fund'] ? '是' : '否' ) : '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">姓名是否与公积金数据匹配：</label></td>
                                        <td>{{ isset($verifInfo['mobile_match_fund']) ? ($verifInfo['mobile_match_fund'] ? '是' : '否' ) : '暂无数据' }}</td>
                                        <td><label class="control-label">手机号码是否与公积金数据匹配：</label></td>
                                        <td>{{ isset($verifInfo['name_match_fund']) ? ($verifInfo['name_match_fund'] ? '是' : '否' ) : '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">身份证号码是否与网银数据匹配：</label></td>
                                        <td>{{ isset($verifInfo['idcard_match_onlinebank']) ? ($verifInfo['idcard_match_onlinebank'] ? '是' : '否' ) : '暂无数据' }}</td>
                                        <td><label class="control-label">姓名是否与网银数据匹配：</label></td>
                                        <td>{{ isset($verifInfo['mobile_match_onlinebank']) ? ($verifInfo['mobile_match_onlinebank'] ? '是' : '否' ) : '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">手机号码是否与网银数据匹配：</label></td>
                                        <td colspan="3">{{ isset($verifInfo['name_match_onlinebank']) ? ($verifInfo['name_match_onlinebank'] ? '是' : '否' ) : '暂无数据' }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <?php $backInfoDetail = $wandInfo->black_info_detail; ?>
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
                                        <td>{{ $backInfoDetail['match_score'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">手机和姓名是否在黑名单：</label></td>
                                        <td>{{ $backInfoDetail['mobile_name_in_blacklist'] ? '是' : '否' }}</td>
                                        <td><label class="control-label">手机和姓名黑名单更新时间：</label></td>
                                        <td>{{ $backInfoDetail['mobile_name_blacklist_updated_time'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">身份证和姓名是否在黑名单：</label></td>
                                        <td>{{ $backInfoDetail['idcard_name_in_blacklist'] ? '是' : '否' }}</td>
                                        <td><label class="control-label">身份证和姓名黑名单更新时间：</label></td>
                                        <td>{{ $backInfoDetail['idcard_name_blacklist_updated_time'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">被标记的黑名单分类：</label></td>
                                        <td colspan="3">{{ isset($backInfoDetail['direct_black_type']) ? ($backInfoDetail['direct_black_type'] ? '是' : '否' ) : '暂无数据' }}</td>
                                    </tr>
                                    <?php $blacklistRecord = $backInfoDetail['blacklist_record'] ?? ''?>
                                    <tr>
                                        <td><label class="control-label">累计借入本金（元）：</label></td>
                                        <td>{{ $blacklistRecord['capital'] ?? '暂无数据'}}</td>
                                        <td><label class="control-label">累计已还金额：</label></td>
                                        <td>{{ $blacklistRecord['paid_amount'] ?? '暂无数据'}}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">累计逾期金额（元）：</label></td>
                                        <td>{{ $blacklistRecord['overdue_amount'] ?? '暂无数据'}}</td>
                                        <td><label class="control-label">最大逾期天数：</label></td>
                                        <?php $overdue_status = [
                                            'M0' => '1~15天',
                                            'M1' => '16~30天',
                                            'M2' => '31~60天',
                                            'M3' => '61~90天',
                                            'M4' => '91~120天',
                                            'M5' => '121~150天',
                                            'M6' => '151~180天',
                                            'M6+' => '大于180天',
                                        ];?>
                                        <td>{{ isset($blacklistRecord['overdue_status']) ? $overdue_status[$blacklistRecord['overdue_status']] : '暂无数据'}}</td>
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
                                        <td>{{ $backInfoDetail['direct_black_count'] ?? '暂无数据'}}</td>
                                        <td><label class="control-label">直接联系人总数：</label></td>
                                        <td>{{ $backInfoDetail['direct_contact_count'] ?? '暂无数据'}}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">间接联系人在黑名单数量：</label></td>
                                        <td>{{ $backInfoDetail['indirect_black_count'] ?? '暂无数据'}}</td>
                                        <td><label class="control-label">引起黑名单的直接联系人数量：</label></td>
                                        <td>{{ $backInfoDetail['introduce_black_count'] ?? '暂无数据'}}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">引起黑名单的直接联系人占比：</label></td>
                                        <td>{{ $backInfoDetail['introduce_black_ratio'] ?? '暂无数据'}}</td>
                                        <td><label class="control-label">被标记的黑名单分类：</label></td>
                                        <td>{{ $backInfoDetail['direct_black_type'] ?? '暂无数据'}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>亲密联系人</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">直接亲密联系人在黑名单数量：</label></td>
                                        <td>{{ $backInfoDetail['direct_intimate_black_count'] ?? '暂无数据'}}</td>
                                        <td><label class="control-label">直接亲密联系人总数：</label></td>
                                        <td>{{ $backInfoDetail['direct_intimate_contact_count'] ?? '暂无数据'}}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">间接亲密联系人在黑名单数量：</label></td>
                                        <td>{{ $backInfoDetail['indirect_intimate_black_count'] ?? '暂无数据'}}</td>
                                        <td><label class="control-label">引起黑名单的直接亲密联系人数量：</label></td>
                                        <td>{{ $backInfoDetail['introduce_intimate_black_count'] ?? '暂无数据'}}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">引起黑名单的直接亲密联系人占比：</label></td>
                                        <td>{{ $backInfoDetail['introduce_intimate_black_ratio'] ?? '暂无数据'}}</td>
                                        <td><label class="control-label">被标记的黑名单分类：</label></td>
                                        <td>{{ $backInfoDetail['direct_intimate_black_type'] ?? '暂无数据'}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <?php $grayInfoDetail = $wandInfo->gray_info_detail; ?>
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>灰名单信息</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">手机和姓名是否在灰名单：</label></td>
                                        <td>{{ $grayInfoDetail['mobile_name_in_gray'] ? '是' : '否'}}</td>
                                        <td><label class="control-label">手机和姓名灰名单更新时间：</label></td>
                                        <td>{{ $grayInfoDetail['mobile_name_gray_updated_time'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">身份证和姓名是否在灰名单：</label></td>
                                        <td>{{ $grayInfoDetail['idcard_name_in_gray'] ? '是' : '否' }}</td>
                                        <td><label class="control-label">身份证和姓名灰名单更新时间：</label></td>
                                        <td>{{ $grayInfoDetail['idcard_name_gray_updated_time'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">被标记的灰名单分类：</label></td>
                                        <td colspan="3">{{ $grayInfoDetail['gray_types'][0] ?? '暂无数据' }}</td>
                                    </tr>
                                    <?php $grayRecord = $wandInfo->gray_info_detail['gray_record'] ?? ''; ?>
                                    <tr>
                                        <td><label class="control-label">累计借入本金：</label></td>
                                        <td>{{ $grayRecord['capital'] ?? '暂无数据' }}</td>
                                        <td><label class="control-label">累计已还金额：</label></td>
                                        <td>{{ $grayRecord['paid_amount'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">累计逾期金额：</label></td>
                                        <td>{{ $grayRecord['overdue_amount'] ?? '暂无数据' }}</td>
                                        <td><label class="control-label">最大逾期天数：</label></td>
                                        <td>{{ isset($grayRecord['overdue_status']) ? $overdue_status[$grayRecord['overdue_status']] : '暂无数据' }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <?php $registerInfo = $wandInfo->register_info; ?>
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>多头信息</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">注册机构数量：</label></td>
                                        <td>{{ $registerInfo['org_count'] }}</td>
                                        <td><label class="control-label">注册机构类型：</label></td>
                                        <td>{{ \App\Strategies\WandStrategy::getOrgTypeText($registerInfo['org_types']) ?: '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">机构查询统计：</label></td>
                                        <td colspan="3">{{ $registerInfo['org_count'] }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <?php $queriedDetail = $wandInfo->queried_detail; ?>
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
                                    @foreach($queriedDetail['queried_analyze'] as $item)
                                        <tr>
                                            <td>{{ $orgTyepMap[$item['org_type']] ?? '暂无数据' }}</td>
                                            <td>{{ $item['loan_cnt_15d'] }}</td>
                                            <td>{{ $item['loan_cnt_30d'] }}</td>
                                            <td>{{ $item['loan_cnt_90d'] }}</td>
                                            <td>{{ $item['loan_cnt_180d'] }}</td>
                                        </tr>
                                    @endforeach
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
                                    @foreach($queriedDetail['queried_infos'] as $item)
                                        <tr>
                                            <td>{{ $item['date'] }}</td>
                                            <td>{{ $orgTyepMap[$item['org_type']] ?? '暂无数据' }}</td>
                                            <td>{{ $item['is_self'] ? '是' : '否' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <?php $suspiciousMobile = $wandInfo->suspicious_mobile; ?>
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
                                        <td>{{ $suspiciousMobile['other_names']['latest_used_time'] ?? '暂无数据' }}</td>
                                        <td><label class="control-label">姓名：</label></td>
                                        <td>{{ $suspiciousMobile['other_names']['name'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>使用过此手机的其他身份证</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">最后使用时间：</label></td>
                                        <td>{{ $suspiciousMobile['other_idcards']['latest_used_time'] ?? '暂无数据' }}</td>
                                        <td><label class="control-label">身份证号码：</label></td>
                                        <td>{{ $suspiciousMobile['other_idcards']['idcard'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>提供数据的机构类型</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">最后使用时间：</label></td>
                                        <td>{{ $suspiciousMobile['information_sources']['latest_used_time'] ?? '暂无数据' }}</td>
                                        <td><label class="control-label">机构类型：</label></td>
                                        <td>{{ isset($suspiciousMobile['information_sources']['org_type']) ? $orgTypeMap[$suspiciousMobile['information_sources']['org_type']] : '暂无数据' }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <?php $suspiciousIdcard = $wandInfo->suspicious_idcard; ?>
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
                                        <td>{{ $suspiciousIdcard['other_names']['latest_used_time'] ?? '暂无数据' }}</td>
                                        <td><label class="control-label">身份证号码：</label></td>
                                        <td>{{ $suspiciousIdcard['other_names']['name'] ?? '暂无数据' }}</td>
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
                                        <td>{{ $suspiciousIdcard['other_mobiles']['latest_used_time'] ?? '暂无数据' }}</td>
                                        <td><label class="control-label">手机号码：</label></td>
                                        <td>{{ $suspiciousIdcard['other_mobiles']['mobile'] ?? '暂无数据' }}</td>
                                        <td><label class="control-label">运营商名称：</label></td>
                                        <td>{{ $suspiciousIdcard['other_mobiles']['carrier'] ?? '暂无数据' }}</td>
                                        <td><label class="control-label">号码归属地：</label></td>
                                        <td>{{ $suspiciousIdcard['other_mobiles']['mobile_location'] ?? '暂无数据' }}</td>
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
                                        <td>{{ $suspiciousIdcard['information_sources']['latest_used_time'] ?? '暂无数据' }}</td>
                                        <td><label class="control-label">机构类型：</label></td>
                                        <td>{{ isset($suspiciousIdcard['information_sources']['org_type']) ? $orgTypeMap[$suspiciousIdcard['information_sources']['org_type']] : '暂无数据' }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <?php $fundInfos = $wandInfo->fund_infos; ?>
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>公积金账户</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">最近数据更新时间：</label></td>
                                        <td>{{ $fundInfos['fund_basic']['update_date'] ?? '暂无数据' }}</td>
                                        <td><label class="control-label">开户时间：</label></td>
                                        <td>{{ $fundInfos['fund_basic']['open_date'] ?? '暂无数据'  }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">开户地区：</label></td>
                                        <td>{{ $fundInfos['fund_basic']['open_location'] ?? '暂无数据'  }}</td>
                                        <td><label class="control-label">账户状态：</label></td>
                                        <td>{{ $fundInfos['fund_basic']['account_status'] ?? '暂无数据'  }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">账户余额：</label></td>
                                        <td>{{ $fundInfos['fund_basic']['balance'] ?? '暂无数据'  }}</td>
                                        <td><label class="control-label">月缴金额：</label></td>
                                        <td>{{ $fundInfos['fund_basic']['monthly_income'] ?? '暂无数据'  }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">基数：</label></td>
                                        <td>{{ $fundInfos['fund_basic']['base_amount'] ?? '暂无数据'  }}</td>
                                        <td><label class="control-label">最近缴纳时间：</label></td>
                                        <td>{{ $fundInfos['fund_basic']['last_pay_date'] ?? '暂无数据'  }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">近一年缴纳月数：</label></td>
                                        <td>{{ $fundInfos['fund_statistics']['total_months'] ?? '暂无数据'  }}</td>
                                        <td><label class="control-label">近一年缴纳单位数：</label></td>
                                        <td>{{ $fundInfos['fund_statistics']['total_companies'] ?? '暂无数据'  }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">近一年连续缴纳月数：</label></td>
                                        <td>{{ $fundInfos['fund_statistics']['continuous_months'] ?? '暂无数据'  }}</td>
                                        <td><label class="control-label">近一年补缴次数：</label></td>
                                        <td>{{ $fundInfos['fund_statistics']['repay_times'] ?? '暂无数据'  }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <?php $debitCardInfo = $wandInfo->debit_card_info; ?>
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>借记卡</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">最近数据更新时间：</label></td>
                                        <td>{{ $debitCardInfo['update_date'] ?? '暂无数据' }}</td>
                                        <td><label class="control-label">卡片数目：</label></td>
                                        <td>{{ $debitCardInfo['card_amount'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">总余额：</label></td>
                                        <td>{{ $debitCardInfo['balance'] ?? '暂无数据' }}</td>
                                        <td><label class="control-label">近一年总收入：</label></td>
                                        <td>{{ $debitCardInfo['total_income'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">近一年工资收入：</label></td>
                                        <td>{{ $debitCardInfo['total_salary_income'] ?? '暂无数据' }}</td>
                                        <td><label class="control-label">近一年贷款收入：</label></td>
                                        <td>{{ $debitCardInfo['total_loan_income'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">近一年总支出：</label></td>
                                        <td>{{ $debitCardInfo['total_outcome'] ?? '暂无数据' }}</td>
                                        <td><label class="control-label">近一年消费支出：</label></td>
                                        <td>{{ $debitCardInfo['total_consume_outcome'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">近一年还贷支出：</label></td>
                                        <td colspan="3">{{ $debitCardInfo['total_loan_outcome'] ?? '暂无数据' }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <table class="table table-condensed table-hover" width="100%">
                                    <?php $creditCardInfo = $wandInfo->credit_card_info; ?>
                                    <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <h5>信用卡</h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">最近数据更新时间：</label></td>
                                        <td>{{ $creditCardInfo['update_date'] ?? '暂无数据' }}</td>
                                        <td><label class="control-label">卡片数目：</label></td>
                                        <td>{{ $creditCardInfo['card_amount'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">总信用额：</label></td>
                                        <td>{{ $creditCardInfo['total_credit_limit'] ?? '暂无数据' }}</td>
                                        <td><label class="control-label">总可用信用额：</label></td>
                                        <td>{{ $creditCardInfo['total_credit_available'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">单一银行最高信用额：</label></td>
                                        <td>{{ $creditCardInfo['max_credit_limit'] ?? '暂无数据' }}</td>
                                        <td><label class="control-label">近一年逾期次数：</label></td>
                                        <td>{{ $creditCardInfo['overdue_times'] ?? '暂无数据' }}</td>
                                    </tr>
                                    <tr>
                                        <td><label class="control-label">近一年逾期月数：</label></td>
                                        <td colspan="3">{{ $creditCardInfo['overdue_months'] ?? '暂无数据' }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            @else
                                暂无数据
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <br>
            <div class="col-sm-5"></div>
            <div class="col-sm2">
                @if($status == \App\Constants\OrderConstant::ORDER_STATUS_PENDING)
                    @if(substr(url()->previous(), -5) != 'order')
                        <a href="{{ route('admin.order.pending.detail.passOrder') }}?order_id={{$order->id}}">
                            <button class="btn btn-primary btn-sm" type="button">
                                通过审批
                            </button>
                        </a>
                        <a href="{{ route('admin.order.pending.detail.refuseOrder') }}?order_id={{$order->id}}">
                            <button class="btn btn-primary btn-sm" type="button">
                                拒绝申请
                            </button>
                        </a>
                    @endif
                @endif
                @if($status == \App\Constants\OrderConstant::ORDER_STATUS_PASSED)
                    <a href="{{ route('admin.order.loan.pass') }}?order_id={{$order->id}}&type=loan">
                        <button class="btn btn-primary btn-sm" type="button">
                            立即放款
                        </button>
                    </a>
                    <a href="{{ route('admin.order.loan.refuse') }}?order_id={{$order->id}}">
                        <button class="btn btn-primary btn-sm" type="button">
                            拒绝放款
                        </button>
                    </a>
                @endif
            </div>
            <div class="col-sm-5"></div>
        </div>
    </div>
@endsection
