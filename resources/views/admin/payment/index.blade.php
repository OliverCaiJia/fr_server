@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox-title">
                <h5>支付管理</h5>
            </div>
            @include('admin.common.status')
            <div class="ibox-content">
                <div class="col-sm-3">
                    {{--<a href="{{ route('admin.user.create') }}" link-url="javascript:void(0)">--}}
                        {{--<button class="btn btn-primary btn-sm" type="button">--}}
                            {{--<i class="fa fa-plus-circle"></i> 添加管理员--}}
                        {{--</button>--}}
                    {{--</a>--}}
                </div>
                <div class="row">
                    <div class="col-sm-8" style="text-align: right">
                        <form action="{{ Request::url() }}" class="form-inline" method="get" id="myform">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="name">用户名:</label>
                                <input placeholder="用户名" name="user_name" class="form-control input-sm"
                                       autocomplete="off"
                                       id="user_name">
                            </div>
                            {{--<div class="form-group">--}}
                                {{--<label for="username">手机号:</label>--}}
                                {{--<input placeholder="手机号" name="mobile" class="form-control input-sm"--}}
                                       {{--autocomplete="off" id="mobile">--}}
                            {{--</div>--}}
                            <button type="submit" class="btn btn-sm btn-primary"> 搜索</button>
                            <button class="btn btn-white btn-sm" type="button" onclick="refresh()">清空</button>
                        </form>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover m-t-md" data-mobile-responsive="true">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>用户名</th>
                        <th>支付平台</th>
                        <th>交易流水号</th>
                        <th>支付渠道</th>
                        <th>订单有效期</th>
                        <th>支付卡的类型</th>
                        <th>支付卡号</th>
                        <th>银行卡后四位</th>
                        <th>订单金额</th>
                        <th>订单状态</th>
                        <th>创建时间</th>
                        <th>更新时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($query as $k => $item)
                        <tr>
                            <td style="word-break:break-all;max-width:350px;">{{$item->id}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{App\Models\Factory\Admin\Users\UsersFactory::getUsername($item->user_id)}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{App\Models\Factory\Admin\Payment\PaymentFactory::getPaymentName($item->payment_id)}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->payment_order_no}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{App\Models\Factory\Admin\Payment\PaymentFactory::getPaymentTypeName($item->payment_type)}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->order_expired}}</td>
                            <td style="word-break:break-all;max-width:350px;">
                                @if($item->bankcard_type == 1)
                                    <span style="color : green;font-weight: bold">借记卡</span>
                                @elseif($item->bankcard_type == 2)
                                    <span style="color : green;font-weight: bold">信用卡</span>
                                @elseif($item->bankcard_type == 3)
                                    <span style="color : green;font-weight: bold">微信</span>
                                @elseif($item->bankcard_type == 4)
                                    <span style="color : green;font-weight: bold">支付宝</span>
                                @endif
                            </td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->bankcard_id}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->lastno}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->amount}}</td>
                            <td style="word-break:break-all;max-width:350px;">
                                @if($item->status == 0)
                                    <span style="color : mediumvioletred;font-weight: bold">未支付</span>
                                @elseif($item->status == 1)
                                    <span style="color : green;font-weight: bold">支付成功</span>
                                @elseif($item->status == 2)
                                    <span style="color : green;font-weight: bold">已撤销</span>
                                @elseif($item->status == 3)
                                    <span style="color : green;font-weight: bold">阻断交易</span>
                                @elseif($item->status == 4)
                                    <span style="color : red;font-weight: bold">失败</span>
                                @elseif($item->status == 5)
                                    <span style="color : green;font-weight: bold">处理中</span>
                                @endif
                            </td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->create_at}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->update_at}}</td>
                            <td>
                                <a href="{{ route('admin.paymentaccount.edit', ['id' => $item->id]) }}">
                                    <button class="btn btn-primary btn-xs" type="button">
                                        <i class="fa fa-paste"></i> 详情
                                    </button>
                                </a>
                                {{--<form action="{{ route('admin.role.destroy', ['id' => $item->id]) }}" method="post"--}}
                                      {{--class="inline">--}}
                                    {{--{{ csrf_field() }}--}}
                                    {{--{{ method_field('DELETE') }}--}}
                                    {{--<button class="btn btn-danger btn-xs" type="submit">--}}
                                        {{--<i class="fa fa-trash-o"></i> 删除--}}
                                    {{--</button>--}}
                                {{--</form>--}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$query->links()}}
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
@endsection

@section('js')
    <script>
        $('#name').val('{{ Request::input('name') }}');
        $('#username').val('{{ Request::input('username') }}');

        function refresh() {
            document.getElementById("myform").reset();
            $('#myform').submit();
        }
    </script>
@endsection
