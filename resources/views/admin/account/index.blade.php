@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox-title">
                <h5>充值记录</h5>
            </div>
            <div class="ibox-content">
                <label>公司名称：{{ $saasAuth->full_company_name }}</label>&nbsp;
                <label>账户名：{{ $saasAuth->account_name }}</label>&nbsp;
                <?php $balance =  App\Helpers\Formater\NumberFormater::roundedAmount
                (\App\Models\Factory\Admin\Saas\SaasAccountFactory::getBalanceById($saasAuth->id))?>
                <label>当前余额：<font @if($balance <= 1000)style="font-size: 39px;color: red"@endif>{{ $balance }}元</font></label>&nbsp;
                <table class="table table-striped table-bordered table-hover m-t-md" data-mobile-responsive="true">
                    <thead>
                    <tr>
                        <th>序号</th>
                        <th>充值金额</th>
                        <th>账户历史余额</th>
                        <th>累计充值金额</th>
                        <th>充值人员</th>
                        <th>充值时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $k => $item)
                        <tr>
                            <td>{{App\Helpers\Utils::generalAutoIncrementId($data, $loop)}}</td>
                            <td>{{App\Helpers\Formater\NumberFormater::roundedAmount($item->balance)}}元</td>
                            <td>{{App\Helpers\Formater\NumberFormater::roundedAmount($item->blc_for_display)}}元</td>
                            <td>{{App\Helpers\Formater\NumberFormater::roundedAmount($item->acc_for_display)}}元</td>
                            <td>{{ \App\Models\Factory\Admin\AdminUserFactory::getNameById($item->create_id) }}</td>
                            <td>{{$item->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$data->links()}}
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
@endsection
