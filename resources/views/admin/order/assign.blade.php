@extends('layouts.layout')
@section('content')
@include('admin.common.status')
<div class="ibox-content">
    <a class="menuid btn btn-primary btn-sm" href="{{URL::previous()}}">返回</a>
    <a href="{{ route('admin.order.pending') }}">
        <button class="btn btn-primary btn-sm" type="button"><i class="fa fa-home"></i> 待处理订单列表</button>
    </a>
    <div class="hr-line-dashed m-t-sm m-b-sm"></div>
    <div id="message"></div>
    <form role="form" action="{{ Request::url() }}" method="post" onsubmit="return checkPost()">
        <div class="form-group">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{ $id }}">
            <label class="col-sm-2 control-label" for="selector-assign">请选择订单处理人员</label>
            <select class="form-control m-b" name="person_id" id="selector-assign" required oninvalid="setCustomValidity('请选择人员后提交');" oninput="setCustomValidity('');">
                @foreach($items as $item)
                    <option value="{{$item['id']}}">{{$item['name']}}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-sm btn-primary"> 提交 </button>
        </div>
    </form>
</div>
<script>
    var isCommited = false;
    function checkPost(){
        if(!isCommited){
            isCommited = true;
            return true;
        }else{
            var div = document.getElementById("message");
            div.innerHTML = "请不要重复提交！";
            return false;
        }
    }
</script>
@endsection
