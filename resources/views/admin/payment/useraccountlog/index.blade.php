@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox-title">
                <h5>用户流水</h5>
            </div>
            @include('admin.common.status')
            <div class="ibox-content">
                <div class="col-sm-3">
                    <a href="{{route('admin.useraccount.index')}}">
                        <button class="btn btn-primary btn-sm" type="button"><i class="fa fa-home"></i>返回上层列表</button>
                    </a>
                    {{--<a href="{{ route('admin.user.create') }}" link-url="javascript:void(0)">--}}
                    {{--<button class="btn btn-primary btn-sm" type="button">--}}
                    {{--<i class="fa fa-plus-circle"></i> 添加管理员--}}
                    {{--</button>--}}
                    {{--</a>--}}
                </div>
                <div class="row">
                    <div class="col-sm-8" style="text-align: right">
                        <form action="{{ Request::url() }}" class="form-inline" method="get" id="myform">
                            {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                            {{--<div class="form-group">--}}
                            {{--<label for="name">用户名:</label>--}}
                            {{--<input placeholder="用户名" name="user_name" class="form-control input-sm"--}}
                            {{--autocomplete="off"--}}
                            {{--id="user_name">--}}
                            {{--</div>--}}
                            {{--<div class="form-group">--}}
                            {{--<label for="username">手机号:</label>--}}
                            {{--<input placeholder="手机号" name="mobile" class="form-control input-sm"--}}
                            {{--autocomplete="off" id="mobile">--}}
                            {{--</div>--}}
                            {{--<button type="submit" class="btn btn-sm btn-primary"> 搜索</button>--}}
                            <button class="btn btn-white btn-sm" type="button" onclick="refresh()">刷新</button>
                        </form>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover m-t-md" data-mobile-responsive="true" style="width: 2000px;">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>交易号</th>
                        <th>用户名</th>
                        <th>类型</th>
                        <th>状态</th>
                        <th>操作金额</th>
                        <th>变化总金额</th>
                        <th>上次总金额</th>
                        <th>这次总金额</th>
                        <th>收入</th>
                        <th>上次总收入</th>
                        <th>当前总收入</th>
                        <th>支出</th>
                        <th>上次总支出</th>
                        <th>当前总支出</th>
                        <th>可用余额变化</th>
                        <th>旧的可用余额</th>
                        <th>最新的金额</th>
                        <th>提现金额</th>
                        <th>上次可提现金额</th>
                        <th>当前可提现金额</th>
                        <th>不可提现冻结金额</th>
                        <th>上次不可提现冻结金额</th>
                        <th>当前不可提现冻结金额</th>
                        <th>冻结金额</th>
                        <th>冻结旧金额</th>
                        <th>新的冻结金额</th>
                        <th>冻结提现金额</th>
                        <th>冻结提现旧金额</th>
                        <th>新的提现冻结金额</th>
                        <th>其他冻结金额</th>
                        <th>其他冻结旧金额</th>
                        <th>其他新的冻结金额</th>
                        <th>待收金额</th>
                        <th>旧的待收余额</th>
                        <th>新的待收余额</th>
                        <th>待还金额</th>
                        <th>旧的待还金额</th>
                        <th>新的待还金额</th>
                        <th>创建时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($query as $k => $item)
                        <tr>
                            <td style="word-break:break-all;max-width:350px;">{{$item->id}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->nid_no}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{App\Models\Factory\Admin\Users\UsersFactory::getUsername($item->user_id)}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->type}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->status}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->money}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->total}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->total_old}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->total_new}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->income}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->income_old}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->income_new}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->expend}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->expend_old}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->expend_new}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->balance}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->balance_old}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->balance_new}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->balance_cash}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->balance_cash_old}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->balance_cash_new}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->balance_frost}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->balance_frost_old}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->balance_frost_new}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->frost}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->frost_old}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->frost_new}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->frost_cash}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->frost_cash_old}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->frost_cash_new}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->frost_other}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->frost_other_old}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->frost_other_new}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->await}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->await_old}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->await_new}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->repay}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->repay_old}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->repay_new}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->create_at }}</td>
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
