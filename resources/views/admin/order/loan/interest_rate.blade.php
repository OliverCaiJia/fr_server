@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            @include('admin.common.status')
            <div class="ibox-content">
                @if(Request::input('type'))
                    <a class="menuid btn btn-primary btn-sm" href="javascript:history.go(-1)">返回</a>
                @else
                    <a class="menuid btn btn-primary btn-sm" href="{{ route('admin.order.passed') }}">返回</a>
                @endif
                <a href="{{ route('admin.order.passed') }}"><button class="btn btn-primary btn-sm" type="button"><i class="fa fa-home"></i> 待放款订单列表</button></a>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <form class="form-horizontal m-t-md" action="{{ Request::url() }}" method="post" accept-charset="UTF-8" enctype="multipart/form-data" id="inte_rate_form">
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" value="{{ $id }}">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">借款金额(*)：</label>
                        <div class="input-group col-sm-2 input_custom">
                            <input type="number" class="form-control" min="1" maxlength="8" name="loan_amounts" value="{{ old('loan_amounts') ?: \App\Helpers\Formater\NumberFormater::roundedAmount(($interestRateInfo->loan_amounts ?? $borrowingBalance), 0) }}" required="" aria-required="true">
                            @if ($errors->has('loan_amounts'))
                                <span class="help-block m-b-none">
                                    <i class="fa fa-info-circle"></i>
                                    {{$errors->first('loan_amounts')}}
                                </span>
                            @endif
                        </div>
                        <span>元</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">正常日利率(*)：</label>
                        <div class="input-group col-sm-2 input_custom">
                            <input type="number" class="form-control" maxlength="8" name="normal_day_rate" value="{{ old('normal_day_rate') ?: ($interestRateInfo->normal_day_rate ?? 1)}}" required data-msg-required="请输入正常日利率">
                            @if ($errors->has('normal_day_rate'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('normal_day_rate')}}</span>
                            @endif
                        </div>
                        <span>%</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">服务费率：</label>
                        <div class="input-group col-sm-2 input_custom">
                            <input type="number" class="form-control" maxlength="8" name="service_rate" value="{{ old('service_rate') ?: ($interestRateInfo->service_rate ?? '') }}">
                            @if ($errors->has('service_rate'))
                                <span class="help-block m-b-none">
                                    <i class="fa fa-info-circle"></i>
                                    {{$errors->first('service_rate')}}
                                </span>
                            @endif
                        </div>
                        <span>%</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">借款周期(*)：</label>
                        <div class="input-group col-sm-2" style="display: inline-block;">
                            <input placeholder="预计放款日期" value="{{ old('lending_date') ?: ($interestRateInfo->lending_date ?? \Carbon\Carbon::now()->format('Y-m-d')) }}" name="lending_date" autocomplete="off" class="form-control layer-date input-sm" id="start" required>
                        </div>
                        <div class="input-group col-sm-2" style="display: inline-block;">
                            <input placeholder="预计还款日期" value="{{ old('repayment_date') ?: ($interestRateInfo->repayment_date ?? \Carbon\Carbon::now()->format('Y-m-d')) }}" name="repayment_date" autocomplete="off" class="form-control layer-date input-sm" id="end" required>
                        </div>
                        @if ($errors->has('repayment_date'))
                            <span class="help-block m-b-none">
                                    <i class="fa fa-info-circle"></i>
                                {{$errors->first('repayment_date')}}
                                </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">逾期日利率(*)：</label>
                        <div class="input-group col-sm-2 input_custom">
                            <input type="number" class="form-control" maxlength="8" name="overdue_daily_rate" value="{{ old('overdue_daily_rate')?: ($interestRateInfo->overdue_daily_rate ?? 3) }}" required data-msg-required="请输入姓名">
                            @if ($errors->has('overdue_daily_rate'))
                                <span class="help-block m-b-none">
                                    <i class="fa fa-info-circle"></i>
                                    {{$errors->first('overdue_daily_rate')}}
                                </span>
                            @endif
                        </div>
                        <span>%</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">借款周期</label>
                        <?php $repaymentDate = $interestRateInfo->repayment_date ?? \Carbon\Carbon::now()->format('Y-m-d');?>
                        <?php $lendingDate = $interestRateInfo->lending_date ?? \Carbon\Carbon::now()->format('Y-m-d');?>
                        <?php $cycle = \Carbon\Carbon::parse($repaymentDate)->diffInDays(\Carbon\Carbon::parse($lendingDate)) + 1; ?>
                        <span class="col-sm-2 control-label span_custom" id="cycle">
                            {{ $cycle }}天
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">本金</label>
                        <span class="col-sm-2 control-label span_custom" id="principal">
                            <?php $principal = \App\Helpers\Formater\NumberFormater::roundedAmount(($interestRateInfo->loan_amounts ?? $borrowingBalance), 2); ?>
                            {{ $principal }}元
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">利息</label>
                        <?php $interest = \App\Helpers\Formater\NumberFormater::roundedAmount(($interestRateInfo->loan_amounts?? $borrowingBalance)*($interestRateInfo->normal_day_rate ?? 1) * 0.01 * $cycle); ?>
                        <span class="col-sm-2 control-label span_custom" id="interest">
                            {{ $interest }}元
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">本息总</label>
                        <span class="col-sm-2 control-label span_custom" id="pr_int">
                            {{ \App\Helpers\Formater\NumberFormater::roundedAmount($principal + $interest) }}元
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">服务费</label>
                        <span class="col-sm-2 control-label span_custom" id="service_amount">
                            <?php $service_amount = \App\Helpers\Formater\NumberFormater::roundedAmount($principal * ($interestRateInfo->service_rate ?? 0) * 0.01); ?>
                            {{ $service_amount }}元
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">实际借出金额</label>
                        <span class="col-sm-2 control-label span_custom" id="actual_amount">
                            {{ \App\Helpers\Formater\NumberFormater::roundedAmount($principal-$service_amount) }}元
                        </span>
                    </div>
                    <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                    <div class="form-group">
                        <div class="col-sm-12 col-sm-offset-2">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-check"></i>&nbsp;
                                    @if(Request::input('type'))
                                        批准放款
                                    @else
                                        保 存
                                    @endif
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
        var start = {
            elem: "#start",
            format: "YYYY-MM-DD",
            max: laydate.now(),
            istime: true,
            istoday: false,
            choose: function (datas) {
                end.min = datas;
                end.start = datas;
                var endDate = new Date($('#end').val());
                var startDate = new Date(datas);
                var day = (endDate - startDate) / 1000 / 60 / 60 / 24 + 1;
                let loan_amounts = $('input[name="loan_amounts"]').val() == ''?0:parseInt($('input[name="loan_amounts"]').val());
                let service_rate = $('input[name="service_rate"]').val() == ''?0:parseInt($('input[name="service_rate"]').val());
                let normal_day_rate = $('input[name="normal_day_rate"]').val();
                let interest = loan_amounts * normal_day_rate * 0.01 * day;
                let pr_int = loan_amounts + interest;
                let actual_amount = loan_amounts - service_rate * loan_amounts * 0.01;
                $('#cycle').html(day + '天');
                $('#interest').html(interest.toFixed(2) + '元');
                $('#pr_int').html(pr_int.toFixed(2) + '元');
                $('#actual_amount').html(actual_amount.toFixed(2) + '元');
            }
        };
        var end = {
            elem: "#end",
            format: "YYYY-MM-DD",
            min: laydate.now(),
            istime: true,
            istoday: false,
            choose: function (datas) {
                start.max = datas;
                var startDate = new Date($('#start').val());
                var endDate = new Date(datas);
                var day = (endDate - startDate) / 1000 / 60 / 60 / 24 + 1;
                let loan_amounts = $('input[name="loan_amounts"]').val() == ''?0:parseInt($('input[name="loan_amounts"]').val());
                let service_rate = $('input[name="service_rate"]').val() == ''?0:parseInt($('input[name="service_rate"]').val());
                let normal_day_rate = $('input[name="normal_day_rate"]').val();
                let interest = loan_amounts * normal_day_rate * 0.01 * day;
                let pr_int = loan_amounts + interest;
                let actual_amount = loan_amounts - service_rate * loan_amounts * 0.01;
                $('#cycle').html(day + '天');
                $('#interest').html(interest.toFixed(2) + '元');
                $('#pr_int').html(pr_int.toFixed(2) + '元');
                $('#actual_amount').html(actual_amount.toFixed(2) + '元');
            }
        };
        laydate(start);
        laydate(end);
    </script>
    <script>
        $(function(){
            //借款金额输入框离开光标
            $('input[name="loan_amounts"]').on('blur',()=>{
                let loan_amounts = $('input[name="loan_amounts"]').val() == ''?0:parseInt($('input[name="loan_amounts"]').val());
                let service_rate = $('input[name="service_rate"]').val() == ''?0:parseInt($('input[name="service_rate"]').val());
                let actual_amount = loan_amounts - service_rate * loan_amounts * 0.01;
                let normal_day_rate = $('input[name="normal_day_rate"]').val();
                let cycle = parseInt($('#cycle').html().replace('天',''));
                let interest = loan_amounts * normal_day_rate * 0.01 * cycle;
                let service_amount = loan_amounts * service_rate * 0.01;
                $('#actual_amount').html(actual_amount.toFixed(2) + '元');
                $('#principal').html(loan_amounts.toFixed(2) + '元');
                $('#interest').html(interest.toFixed(2) + '元');
                $('#service_amount').html(service_amount.toFixed(2) + '元');
            });

            //正常日利率输入框离开光标
            $('input[name="normal_day_rate"]').on('blur',()=>{
                let loan_amounts = $('input[name="loan_amounts"]').val() == ''?0:parseInt($('input[name="loan_amounts"]').val());
                let normal_day_rate = $('input[name="normal_day_rate"]').val();
                let interest = loan_amounts * normal_day_rate * 0.01;
                let pr_int = loan_amounts + interest;
                $('#interest').html(interest.toFixed(2) + '元');
                $('#pr_int').html(pr_int.toFixed(2) + '元');
            })

            //服务费率输入框离开光标
            $('input[name="service_rate"]').on('blur',()=>{
                let loan_amounts = $('input[name="loan_amounts"]').val() == ''?0:parseInt($('input[name="loan_amounts"]').val());
                let service_rate = $('input[name="service_rate"]').val() == ''?0:parseInt($('input[name="service_rate"]').val());
                let actual_amount = loan_amounts - service_rate * loan_amounts * 0.01;
                let service_amount = loan_amounts * service_rate * 0.01;
                $('#actual_amount').html(actual_amount.toFixed(2) + '元');
                $('#service_amount').html(service_amount.toFixed(2) + '元');
            });
        })

        $.validator.setDefaults({
            highlight: function (e) {
                $(e).closest(".form-group").removeClass("has-success").addClass("has-error")
            }, success: function (e) {
                e.closest(".form-group").removeClass("has-error").addClass("has-success")
            }, errorElement: "span", errorPlacement: function (e, r) {
                e.appendTo(r.is(":radio") || r.is(":checkbox") ? r.parent().parent().parent() : r.parent())
            }, errorClass: "help-block m-b-none", validClass: "help-block m-b-none"
        }), $().ready(function () {
            var e = "<i class='fa fa-times-circle'></i> ";
            $("#inte_rate_form").validate({
                rules: {
                    loan_amounts: {required:true, min:1, digits:true, maxlength:8},
                    normal_day_rate: {required:true, min:0.000001, maxlength:8},
                    service_rate: {min:0, maxlength:8},
                    overdue_daily_rate: {required:true, min:0.000001, maxlength:8},
                },
                messages: {
                    loan_amounts: {required: e + "请输入借款金额", min:e + "请输入正整数", digits:e + "请输入正整数", maxlength:"最长8个字符"},
                    normal_day_rate: {required: e + "请输入正常日利率", min:e + "请输入正数", maxlength:e + "最大8字符"},
                    service_rate: {min:e + "请输入正数", maxlength:e + "最大8字符"},
                    overdue_daily_rate: {required: e + "请输入逾期日利率", min:e + "请输入正数", maxlength:e + "最大8字符"},
                }
            })
        });
    </script>
@endsection
