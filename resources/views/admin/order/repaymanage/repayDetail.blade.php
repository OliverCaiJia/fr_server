@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            @include('admin.common.status')
            <div class="ibox-content">
                <a class="menuid btn btn-primary btn-sm" href="javascript:history.go(-1)">返回</a>
                <a href="{{ route('admin.order.repaymanage.repaying') }}"><button class="btn btn-primary btn-sm" type="button"><i class="fa fa-home"></i> 待还款订单列表</button></a>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <form class="form-horizontal m-t-md" action="" method="post" accept-charset="UTF-8" enctype="multipart/form-data" id="commentForm">
                    {!! csrf_field() !!}
                    <input type="hidden" name="saas_order_id" value="{{ $saasOrderInfo->saas_order_id }}">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">本金</label>
                        <span class="col-sm-2 control-label span_custom" id="principal">
                            {{ $saasOrderInfo->loan_amounts }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">借款周期</label>
                        <span class="col-sm-2 control-label span_custom" id="cycle">
                            {{ $saasOrderInfo->lending_date }} -- {{ $saasOrderInfo->repayment_date }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">借款周期</label>
                        <span class="col-sm-2 control-label span_custom" id="payment_cycle">
                            {{ $term = (strtotime($saasOrderInfo->repayment_date) - strtotime($saasOrderInfo->lending_date))/86400 + 1 }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">正常日利率</label>
                        <span class="col-sm-2 control-label span_custom" id="normal_day_rate">
                            {{ $saasOrderInfo->normal_day_rate }} %
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">服务费率</label>
                        <span class="col-sm-2 control-label span_custom" id="service_rate">
                            {{ $saasOrderInfo->service_rate }} %
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">利息</label>
                        <span class="col-sm-2 control-label span_custom" id="interest">
                            {{ $lixi = \App\Helpers\Formater\NumberFormater::roundedAmount($saasOrderInfo->loan_amounts * $term * $saasOrderInfo->normal_day_rate / 100, 2) }} 元
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">本息总</label>
                        <span class="col-sm-2 control-label span_custom" id="pr_int">
                            {{ $lixi + $saasOrderInfo->loan_amounts }} 元
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">还款类型</label>
                        <div class="input-group col-sm-2 control-label span_custom">
                            <input type="radio" name="type" checked value="1" class="type_radio">正常还款
                            <input type="radio" name="type" value="2" class="type_radio">提前还款
                        </div>
                    </div>
                    <div class="form-group repayment_type_block" style="display: none;">
                        <label class="col-sm-2 control-label">实际还款日期</label>
                        <div class="input-group col-sm-2">
                            <input placeholder="" name="repayment_date" autocomplete="off" class="form-control layer-date input-sm" id="repayment_date" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">实际还款金额</label>
                        <div class="input-group col-sm-2 input_custom">
                            <input type="text" class="form-control" maxlength="8" name="repayment_amount" value="{{ $lixi + $saasOrderInfo->loan_amounts }}" required data-msg-required="请输入借款金额">
                        </div>
                        <span>元</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">还款方式</label>
                        <div class="input-group col-sm-2">
                            <select name="repayment_method">
                                <option value="1">微信</option>
                                <option value="2">支付宝</option>
                                <option value="3">其他</option>
                            </select>
                        </div>
                    </div>
                    <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                    <div class="form-group">
                        <div class="col-sm-12 col-sm-offset-2">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-check"></i>&nbsp;
                                    确认还款
                            </button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('vendor/hui/js/plugins/layer/laydate/laydate.js') }}"></script>
    <script>
        var repayment_date = {
            elem: "#repayment_date",
            format: "YYYY-MM-DD",
//            max: laydate.now(),
            istime: true,
            istoday: false,
//            choose: function (datas) {
//                end.min = datas;
//                end.start = datas
//            }
        };
        laydate(repayment_date);

        $(function() {
            //运营商认证开关
            var selectValue = $('input[name="type"]:checked').val();
            console.log(selectValue);
            if (selectValue == 1) {
                $(".repayment_type_block").hide();
            } else {
                $(".repayment_type_block").hide();
            }

            var isPermanentValue = $('input[name="type"]:checked ').val();
            if (isPermanentValue == 1) {
                $(".repayment_type_block").hide();
            }
            if (isPermanentValue == 2) {
                $(".repayment_type_block").show();
            }
            $(".type_radio").click(function () {
                var isPermanentValue = $('input[name="type"]:checked').val();
                console.log(isPermanentValue);
                if (isPermanentValue == 1) {
                    $(".repayment_type_block").hide();
                }
                if (isPermanentValue == 2) {
                    $(".repayment_type_block").show();
                }
            })
        })
    </script>
@endsection
