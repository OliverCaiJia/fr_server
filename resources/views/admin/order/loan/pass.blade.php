@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox-title">
                <h5>立即放款</h5>
            </div>
            <div class="ibox-content">
                <a class="menuid btn btn-primary btn-sm" href="javascript:history.go(-1)">返回</a>
                <a href="{{ route('admin.order.loan.pass') }}"><button class="btn btn-primary btn-sm" type="button"><i class="fa fa-home"></i> 待放款订单列表</button></a>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <form class="form-horizontal m-t-md" action="{{ route('admin.order.loan.pass') }}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" value="{{ $id }}">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">借款金额(*)：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="loan_amounts" value="{{ \App\Helpers\Formater\NumberFormater::roundedAmount(old('loan_amounts') ?: ($interestRateInfo->loan_amounts ?? $borrowingBalance), 0) }}" required data-msg-required="请输入借款金额">
                            @if ($errors->has('loan_amounts'))
                                <span class="help-block m-b-none">
                                    <i class="fa fa-info-circle"></i>
                                    {{$errors->first('loan_amounts')}}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">正常日利率(*)：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="normal_day_rate" value="{{ old('normal_day_rate') ?: ($interestRateInfo->normal_day_rate ?? 1)}}" required data-msg-required="请输入正常日利率">
                            @if ($errors->has('normal_day_rate'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('normal_day_rate')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">服务费率：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="service_rate" value="{{ old('service_rate') ?: ($interestRateInfo->service_rate ?? 0) }}">
                            @if ($errors->has('service_rate'))
                                <span class="help-block m-b-none">
                                    <i class="fa fa-info-circle"></i>
                                    {{$errors->first('service_rate')}}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">借款周期(*)：</label>
                        <div class="input-group col-sm-2">
                            <input placeholder="开始日期" value="{{ old('lending_date') ?: ($interestRateInfo->lending_date ?? \Carbon\Carbon::now()->format('Y-m-d')) }}" name="lending_date" autocomplete="off" class="form-control layer-date input-sm" id="start">
                            <input placeholder="结束日期" value="{{ old('repayment_date') ?: ($interestRateInfo->repayment_date ?? \Carbon\Carbon::now()->format('Y-m-d')) }}" name="repayment_date" autocomplete="off" class="form-control layer-date input-sm" id="end">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">逾期日利率(*)：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="overdue_daily_rate" value="{{ old('overdue_daily_rate')?: ($interestRateInfo->overdue_daily_rate ?? 3) }}" required data-msg-required="请输入姓名">
                            @if ($errors->has('overdue_daily_rate'))
                                <span class="help-block m-b-none">
                                    <i class="fa fa-info-circle"></i>
                                    {{$errors->first('overdue_daily_rate')}}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">借款周期</label>
                        <div class="input-group col-sm-2">
                            7天
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">本金</label>
                        <div class="input-group col-sm-2">
                            2000.00天
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">利息</label>
                        <div class="input-group col-sm-2">
                            2000.00天
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">本息总</label>
                        <div class="input-group col-sm-2">
                            2000.00天
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">服务费</label>
                        <div class="input-group col-sm-2">
                            2000.00天
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">实际借出金额</label>
                        <div class="input-group col-sm-2">
                            2000.00天
                        </div>
                    </div>
                    <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                    <div class="form-group">
                        <div class="col-sm-12 col-sm-offset-2">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i>&nbsp;保 存</button>
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
                end.start = datas
            }
        };
        var end = {
            elem: "#end",
            format: "YYYY-MM-DD",
            max: laydate.now(),
            istime: true,
            istoday: false,
            choose: function (datas) {
                start.max = datas
            }
        };
        laydate(start);
        laydate(end);
    </script>
@endsection
