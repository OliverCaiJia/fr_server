@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox-title">
                <h5>订单记录</h5>
            </div>
            <div class="ibox-content">
                <div class="col-sm-12">
                    <form action="{{ Request::url() }}" class="form-inline" method="post" id="myform">
                        <input type="hidden" name="_token" autocomplete="off" value="{{ csrf_token() }}">
                        <table>
                            <tr>
                            <td colspan="3">
                            <a href="{{ route('admin.order.index', [
                            'start' => Request::input('start') ?: \Carbon\Carbon::now()->subMonth()->format('Y-m-d') . ' 00:00:00',
                            'end' => Request::input('end') ?: \Carbon\Carbon::now()->format('Y-m-d') . ' 23:59:59',
                            'status' => Request::input('status') ?: 0,
                            'province' => Request::input('province') ?: 0,
                            'user_name' => Request::input('user_name') ?: '',
                            'user_id_card' => Request::input('user_id_card') ?: 0,
                            'user_mobile' => Request::input('user_mobile') ?: 0,
                            'export' => 1
                            ]) }}">
                            <button class="btn btn-primary btn-sm" type="button">
                            <i class="fa fa-download"></i>&nbsp;&nbsp;<span class="bold">全部导出</span>
                            </button></a>
                            </td>
                            <td>&nbsp;</td>
                            <td>
                            <button type="submit" class="btn btn-sm btn-primary"> 搜索</button>
                            <button class="btn btn-white btn-sm" type="button" onclick="refresh()">清空</button>
                            </td>
                            </tr>
                            <tr>
                            <td>&nbsp;</td>
                            </tr>
                            <tr>
                            <td>
                            <label>申请时间：</label>
                            </td>
                            <td>
                            <input placeholder="开始日期" name="start" autocomplete="off" class="form-control layer-date input-sm" id="start"
                            value="{{ Request::input('start') }}">
                            <input placeholder="结束日期" name="end" autocomplete="off" class="form-control layer-date input-sm" id="end"
                            value="{{ Request::input('end') }}">
                            </td>
                            <td>
                            <label for="status">&nbsp;&nbsp;订单状态：</label>
                            </td>
                            <td>
                            <select name="status" class="form-control" id="status" autocomplete="off">
                            <option value="0">全部</option>
                            <option value="1" @if(Request::input('status') == '1') selected @endif>待初审订单</option>
                            <option value="3" @if(Request::input('status') == '3') selected @endif>审核不通过</option>
                            <option value="2" @if(Request::input('status') == '2') selected @endif>待放款订单</option>
                            <option value="4" @if(Request::input('status') == '4') selected @endif>已拒绝放款</option>
                            <option value="5" @if(Request::input('status') == '5') selected @endif>待还款订单</option>
                            <option value="6" @if(Request::input('status') == '6') selected @endif>逾期未还订单</option>
                            <option value="7" @if(Request::input('status') == '7') selected @endif>已还款订单</option>
                            </select>
                            </td>
                            <td>
                            <label>&nbsp;&nbsp;户籍省份：</label>
                            </td>
                            <td>
                            <input placeholder="户籍省份" name="province" autocomplete="off" class="form-control input-sm" id="province"
                            value="{{ Request::input('province') }}">
                            </td>
                            <td>
                            <label for="status">&nbsp;&nbsp;状态：</label>
                            </td>
                            <td>
                            <select name="apply_status" class="form-control" id="apply_status" autocomplete="off">
                            <option value="0">全部</option>
                            <option value="1" @if(Request::input('apply_status') == '1') selected @endif>注册完成</option>
                            <option value="2" @if(Request::input('apply_status') == '2') selected @endif>实名完成</option>
                            <option value="3" @if(Request::input('apply_status') == '3') selected @endif>申请完成</option>
                            </select>
                            </td>
                            </tr>
                            <tr>
                            <td>&nbsp;</td>
                            </tr>
                            <tr>
                            <td>
                            <label>姓名：</label>
                            </td>
                            <td>
                            <input placeholder="姓名" name="user_name" autocomplete="off" class="form-control input-sm" id="user_name"
                            value="{{ Request::input('user_name') }}">
                            </td>
                            <td>
                            <label>&nbsp;&nbsp;手机号：</label>
                            </td>
                            <td>
                            <input placeholder="手机号" name="user_mobile" autocomplete="off" class="form-control input-sm" id="user_mobile"
                            value="{{ Request::input('user_mobile') }}">
                            </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="row">
                </div>
                <div class="table_custom">
                    <table class="table table-striped table-bordered table-hover m-t-md" data-mobile-responsive="true">
                    {{--@if($orders->total()) style="width: 2000px" @endif>--}}
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>用户名</th>
                        <th>订单号</th>
                        <th>订单类型</th>
                        <th>订单有效期</th>
                        <th>订单金额</th>
                        <th>银行卡号</th>
                        <th>借贷金额</th>
                        <th>订单期限</th>
                        <th>订单数量</th>
                        <th>订单状态</th>
                        <th>用户支付时终端IP</th>
                        <th>创建时间</th>
                        <th>更新IP</th>
                        <th>更新时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($query as $k => $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{App\Models\Factory\Admin\Users\UsersFactory::getUsername($item->user_id)}}</td>
                            <td>{{ $item->order_no }}</td>
                            <td>{{App\Models\Factory\Admin\Order\OrderFactory::getOrderTypeByName($item->order_type)}}</td>
                            <td>{{ $item->order_expired }}</td>
                            <td>{{ $item->amount }}</td>
                            <td>{{ $item->card_no }}</td>
                            <td>{{ $item->money }}</td>
                            <td>{{ $item->term }}</td>
                            <td>{{ $item->count }}</td>
                            <td>
                                @if($item->status == 0)
                                    <span style="color : green;font-weight: bold">订单处理中</span>
                                @elseif($item->status == 1)
                                    <span style="color : green;font-weight: bold">订单完成</span>
                                @elseif($item->status == 2)
                                    <span style="color : red;font-weight: bold">订单过期</span>
                                @elseif($item->status == 3)
                                    <span style="color : green;font-weight: bold">订单撤销</span>
                                @elseif($item->status == 4)
                                    <span style="color: red;font-weight: bold;">订单失败</span>
                                @endif
                            </td>
                            <td>{{ $item->create_ip }}</td>
                            <td>{{ $item->create_at }}</td>
                            <td>{{ $item->update_ip }}</td>
                            <td>{{ $item->update_at }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{--{{ route('admin.order.detail', ['id' => $item->id]) }}--}}">
                                        <button class="btn btn-primary btn-xs" type="button">
                                            <i class="fa fa-paste"></i> 详情
                                        </button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div>
                {{--{{ $query->appends([--}}
                {{--'start' => Request::input('start') ?: \Carbon\Carbon::now()->subMonth()->format('Y-m-d') . ' 00:00:00',--}}
                {{--'end' => Request::input('end') ?: \Carbon\Carbon::now()->format('Y-m-d') . ' 23:59:59',--}}
                {{--'status' => Request::input('status') ?: 0,--}}
                {{--'apply_status' => Request::input('apply_status'),--}}
                {{--'user_name' => Request::input('user_name') ?: '',--}}
                {{--'user_id_card' => Request::input('user_id_card') ?: '',--}}
                {{--'user_mobile' => Request::input('user_mobile') ?: '',--}}
                {{--'province' => Request::input('province'),--}}
                {{--])->links() }}--}}
                {{$query->links()}}
                {{--<div>总计金额：{{ $totalPrice }} 元</div>--}}
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('vendor/hui/js/plugins/layer/laydate/laydate.js') }}"></script>
    <script>
        var start = {
            elem: "#start",
            format: "YYYY-MM-DD hh:mm:ss",
            max: laydate.now(),
            istime: true,
            istoday: false,
            choose: function (datas) {
                end.min = datas;
                end.start = datas
            }
        };
        var end = {
            elem: "#end",
            format: "YYYY-MM-DD hh:mm:ss",
            max: laydate.now(),
            istime: true,
            istoday: false,
            choose: function (datas) {
                start.max = datas
            }
        };
        laydate(start);
        laydate(end);
        $('#start').val('{{ Request::input('start') ?: \Carbon\Carbon::now()->subMonth()->format('Y-m-d') . ' 00:00:00' }}');
        $('#end').val('{{ Request::input('end') ?: \Carbon\Carbon::now()->format('Y-m-d') . ' 23:59:59' }}');
        $('#user_name').val('{{ Request::input('user_name') }}');
        $('#user_id_card').val('{{ Request::input('user_id_card') }}');
        $('#user_mobile').val('{{ Request::input('user_mobile') }}');
        $('#province').val('{{ Request::input('province') }}');

        function refresh() {
            document.getElementById("myform").reset();
            $('#status').val(0);
            $('#myform').submit();
        }
    </script>
@endsection
