@extends('layouts.layout')
@section('content')
    @include('admin.common.status')
    <div class="ibox-content">
        <a class="menuid btn btn-primary btn-sm" href="javascript:history.go(-1)">返回</a>
        <a href="{{ route('admin.order.pending') }}">
            <button class="btn btn-primary btn-sm" type="button"><i class="fa fa-home"></i> 待处理订单列表</button>
        </a>
        <div class="hr-line-dashed m-t-sm m-b-sm"></div>
        <div>
            <form action="{{ Request::url() }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="order_id" value="{{ $id }}">
                <div class="form-group">
                    <input type="text" placeholder="请输入拒绝理由" name="reason" class="form-control input-lg" maxlength="100" required>
                    <div class=""></div>
                </div>
                <button type="submit" class="btn btn-sm btn-primary"> 提交 </button>
            </form>
        </div>
    </div>
@endsection
