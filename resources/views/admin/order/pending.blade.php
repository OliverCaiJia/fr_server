@extends('layouts.layout')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox-title">
                    <h5>待处理订单</h5>
                </div>
                @include('admin.common.status')
                @include('admin.order.upload')
                <div class="ibox-content">
                    <form action="{{ Request::url() }}" class="form-inline" method="post" id="myform">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <table>
                            <tr>
                                <td colspan="3">
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#myModal">
                                                <i class="fa fa-upload"></i>&nbsp;&nbsp;<span class="bold">订单上传</span>
                                            </button>
                                            <a href="{{ route('admin.order.download.template') }}">
                                                <button class="btn btn-primary btn-sm" type="button">
                                                    <i class="fa fa-download"></i>&nbsp;&nbsp;<span class="bold">模板下载</span>
                                                </button>
                                            </a>
                                            @if (Gate::check('admin.order.pending.batchAssign'))
                                                <button class="btn btn-primary btn-sm" type="button" data-toggle="modal"
                                                        data-target="#temp_window" onclick="subm()" id="batch_insert_dialog">
                                                    <i class="fa fa-th-list"></i>&nbsp;&nbsp;<span class="bold">批量分配</span>
                                                </button>
                                            @endif
                                        </div>
                                        @if ($errors->has('file'))
                                            <span class="help-block m-b-none">
                                                <i class="fa fa-info-circle"></i>{{$errors->first('file')}}
                                            </span>
                                        @endif
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    <label>申请时间：</label>
                                </td>
                                <td>
                                    <input placeholder="开始日期" name="start" autocomplete="off" class="form-control layer-date input-sm" id="start">
                                    <input placeholder="结束日期" name="end" autocomplete="off" class="form-control layer-date input-sm" id="end">
                                </td>
                                <td>
                                    <label>&nbsp;&nbsp;户籍省份：</label>
                                </td>
                                <td>
                                    <input placeholder="户籍省份" name="province" autocomplete="off" class="form-control input-sm" id="province">
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    <label>年龄：</label>
                                </td>
                                <td>
                                    <input placeholder="年龄下限" name="age_low" autocomplete="off" type="number" class="form-control input-sm"
                                           id="age_low" min="0">
                                    <input placeholder="年龄上限" name="age_high" autocomplete="off" type="number" class="form-control input-sm"
                                           id="age_high" min="0">
                                </td>
                                <td>&nbsp;</td>
                                <td>
                                    <button type="submit" class="btn btn-sm btn-primary"> 搜索</button>
                                    <button class="btn btn-white btn-sm" type="button" onclick="refresh()">清空</button>
                                </td>
                            </tr>
                        </table>
                    </form>

                    <div class="row"></div>
                    <table class="table table-striped table-bordered table-hover m-t-md">
                        <thead>
                        <tr>
                            <th width="26">
                                <input type="checkbox" onclick="checkAll(this)">
                            </th>
                            <th>序号</th>
                            <th>姓名</th>
                            <th>证件号</th>
                            <th>年龄</th>
                            <th>户籍省份</th>
                            <th>手机号</th>
                            <th>金额</th>
                            <th>周期</th>
                            <th>还款方式</th>
                            <th>渠道</th>
                            <th>申请时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $k => $item)
                            <?php $userInfo = App\Models\Factory\Admin\Order\ReportFactory::getUserBasicInfoByReportId($item['user_report_id']); ?>
                            <tr class="gradeX">
                                <td><input type="checkbox" name="ids" data-toggle="icheck" value="{{$item['id']}}"></td>
                                <td>{{App\Helpers\Utils::generalAutoIncrementId($orders, $loop)}}</td>
                                <td>{{$userInfo['name']}}</td>
                                <td>{{$userInfo['id_card']}}</td>
                                <td>{{$item['age']}}</td>
                                <td>{{$item['province']}}</td>
                                <td>{{$userInfo['mobile']}}</td>
                                <td>{{App\Helpers\Formater\NumberFormater::roundedAmount($item['amount'])}}元</td>
                                <td>{{$item['cycle']}}天</td>
                                <td>{{\App\Constants\OrderConstant::ORDER_PAYMENT_METHOD[$item['repayment_method']]}}</td>
                                <td>{{\App\Strategies\UserOrderStrategy::getChannelText($item)}}</td>
                                <td>{{ $item->assigned_at }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{route('admin.order.detail', ['id' => $item['id']])}}">
                                            <button class="btn btn-primary btn-xs" type="button">
                                                <i class="fa fa-paste"></i> 查看
                                            </button>
                                        </a>
                                        <a href="{{route('admin.order.pending.assign')}}?id={{$item['id']}}">
                                            <button class="btn btn-primary btn-xs" type="button">
                                                <i class="fa fa-paste"></i> 分配
                                            </button>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </form>
                    {{ $orders->appends([
                    'start' => Request::input('start') ?: \Carbon\Carbon::now()->subMonth()->format('Y-m-d') . ' 00:00:00',
                    'end' => Request::input('end') ?: \Carbon\Carbon::now()->format('Y-m-d') . ' 23:59:59',
                    'age_low' => Request::input('age_low'),
                    'age_high' => Request::input('age_high'),
                    'province' => Request::input('province'),
                    ])->links() }}
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    @include('admin.order.batchAssign')
@endsection
@section('js')
    <script src="{{ asset('vendor/hui/js/content.min.js') }}"></script>
    <script src="{{ asset('vendor/hui/js/plugins/prettyfile/bootstrap-prettyfile.js') }}"></script>
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
        $('#age_low').val('{{ Request::input('age_low') }}');
        $('#age_high').val('{{ Request::input('age_high') }}');
        $('#province').val('{{ Request::input('province') }}');
    </script>
    <script>
        function checkAll(obj){
            if(obj.checked){
                $("table input[type=checkbox]").prop("checked",true);
            }else{
                $("table input[type=checkbox]").removeAttr("checked");
            }
        }
        function subm() {
            var id_array=new Array();
            $('input[name="ids"]:checked').each(function(){
                id_array.push($(this).val());//向数组中添加元素
            });
            var idstr=id_array.join(',');//将数组元素连接起来以构建一个字符串
            $('#order_id').val(idstr);
        }
        function refresh() {
            document.getElementById("myform").reset();
            $('#myform').submit();
        }
    </script>
@endsection
