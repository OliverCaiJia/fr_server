@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox-title">
                <h5>待还款订单</h5>
            </div>
            <div class="ibox-content">
                @include('admin.common.status')
                <div class="col-sm-12">
                    <form action="{{ Request::url() }}" class="form-inline" method="post" id="myform">
                        <input type="hidden" name="_token" autocomplete="off" value="{{ csrf_token() }}">
                    <table>
                        <tr>
                            <td colspan="3">
                                <a href="{{ route('admin.order.repaymanage.repaying', [
                                'start' => Request::input('start') ?: \Carbon\Carbon::now()->subMonth()->format('Y-m-d') . ' 00:00:00',
                                'end' => Request::input('end') ?: \Carbon\Carbon::now()->format('Y-m-d') . ' 23:59:59',
                                'status' => Request::input('status') ?: 0,
                                'user_name' => Request::input('user_name') ?: '',
                                'user_mobile' => Request::input('user_mobile') ?: 0,
                                'export' => 1
                             ]) }}"></a>
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
                            <td>&nbsp;</td>
                            <td>
                                <button type="submit" class="btn btn-sm btn-primary"> 查询</button>
                                <button class="btn btn-white btn-sm" type="button" onclick="refresh()">清空</button>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                                <label>放款日期：</label>
                            </td>
                            <td>
                                <input placeholder="开始日期" name="lending_date_start" autocomplete="off" class="form-control layer-date input-sm" id="lending_date_start"
                                       value="{{ Request::input('lending_date_start') }}">
                                <input placeholder="结束日期" name="lending_date_end" autocomplete="off" class="form-control layer-date input-sm" id="lending_date_end"
                                       value="{{ Request::input('lending_date_end') }}">
                            </td>

                            <td>
                                <label>还款日期：</label>
                            </td>
                            <td>
                                <input placeholder="开始日期" name="repayment_date_start" autocomplete="off" class="form-control layer-date input-sm" id="repayment_date_start"
                                       value="{{ Request::input('repayment_date_start') }}">
                                <input placeholder="结束日期" name="repayment_date_end" autocomplete="off" class="form-control layer-date input-sm" id="repayment_date_end"
                                       value="{{ Request::input('repayment_date_end') }}">
                            </td>
                        </tr>
                    </table>
                    </form>
                </div>
                <div class="row"></div>
                <div @if($orders->total()) class="table_custom" @endif>
                    <table class="table table-striped table-bordered table-hover m-t-md" data-mobile-responsive="true" @if($orders->total()) style="width: 2000px" @endif>
                        <thead>
                        <tr>
                            <th>序号</th>
                            <th>姓名</th>
                            <th>手机号</th>
                            <th>本金</th>
                            <th>借款周期（天）</th>
                            <th>正常日利率</th>
                            <th>服务费率</th>
                            <th>利息（元）</th>
                            <th>本息总（元）</th>
                            <th>放款日期</th>
                            <th>还款日期</th>
                            <th>订单状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $item)
                            <?php $userInfo = App\Models\Factory\Admin\Order\ReportFactory::getUserBasicInfoByReportId($item['user_report_id']); ?>
                            <?php $term = (strtotime($item->repayment_date) - strtotime($item->lending_date))/86400 + 1 ?>
                            <tr>
                                <td>{{App\Helpers\Utils::generalAutoIncrementId($orders, $loop)}}</td>
                                <td>{{ $userInfo['name'] ?? '--' }}</td>
                                <td>{{ $userInfo['mobile'] ?: \App\Models\Factory\Admin\Users\UsersFactory::getUserInfoById($item->user_id)['mobile'] }}</td>
                                <td>{{ $item->loan_amounts }}</td>
                                <td>{{ $term }}</td>
                                <td>{{ $item->normal_day_rate }} %</td>
                                <td>{{ $item->service_rate }} %</td>
                                <td>{{ $term * $item->normal_day_rate * $item->loan_amounts / 100 }}</td>
                                <td>{{ $term * $item->normal_day_rate * $item->loan_amounts / 100 + $item->loan_amounts }}</td>
                                <td>{{ $item->lending_date }}</td>
                                <td>{{ $item->repayment_date }}</td>
                                <td>待还款</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.order.repaymanage.repaydetail', ['saas_order_id' => $item->saas_order_id]) }}">
                                            <button class="btn btn-primary btn-xs" type="button">还款标记
                                            </button>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @include('admin.common.no-content')
                {{ $orders->appends([
                    'repayment_date_start' => Request::input('repayment_date_start') ?: date('Y-m-d'),
                    'repayment_date_end' => Request::input('repayment_date_end'),
                    'lending_date_start' => Request::input('lending_date_start'),
                    'lending_date_end' => Request::input('lending_date_end'),
                    'user_name' => Request::input('user_name'),
                    'user_mobile' => Request::input('user_mobile')
                    ])->links() }}
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('vendor/hui/js/plugins/layer/laydate/laydate.js') }}"></script>
    <script>
        var lending_date_start = {
            elem: "#lending_date_start",
            format: "YYYY-MM-DD hh:mm:ss",
            max: laydate.now(),
            istime: true,
            istoday: false,
//            choose: function (datas) {
//                end.min = datas;
//                end.start = datas
//            }
        };
        var lending_date_end = {
            elem: "#lending_date_end",
            format: "YYYY-MM-DD hh:mm:ss",
            max: laydate.now(),
            istime: true,
            istoday: false,
//            choose: function (datas) {
//                start.max = datas;
//            }
        };
        var repayment_date_start = {
            elem: "#repayment_date_start",
            format: "YYYY-MM-DD hh:mm:ss",
            min: laydate.now(),
            istime: true,
            istoday: false,
//            choose: function (datas) {
//                repayment_date_end.min = datas;
//                repayment_date_end.start = datas
//            }
        };
        var repayment_date_end = {
            elem: "#repayment_date_end",
            format: "YYYY-MM-DD hh:mm:ss",
            min: laydate.now(),
            istime: true,
            istoday: false,
//            choose: function (datas) {
//                repayment_date_start.max = datas;
//            }
        };
        laydate(lending_date_start);
        laydate(lending_date_end);
        laydate(repayment_date_start);
        laydate(repayment_date_end);
        $('#lending_date_start').val('{{ Request::input('lending_date_start') }}');
        $('#lending_date_end').val('{{ Request::input('lending_date_end') }}');
        $('#repayment_date_start').val('{{ Request::input('repayment_date_start') }}');
        $('#repayment_date_end').val('{{ Request::input('repayment_date_end') }}');
        $('#user_name').val('{{ Request::input('user_name') }}');
        $('#user_mobile').val('{{ Request::input('user_mobile') }}');
        function refresh() {
            document.getElementById("myform").reset();
            $('#myform').submit();
        }
    </script>
@endsection
