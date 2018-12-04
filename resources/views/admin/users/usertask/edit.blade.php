@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox-title">
                <h5>修改用户</h5>
            </div>
            @include('admin.common.status')
            <div class="ibox-content">
                <a href="{{route('admin.usertask.index')}}"><button class="btn btn-primary btn-sm" type="button"><i class="fa fa-home"></i>返回用户列表</button></a>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">请求数据：</label>
                        <div class="input-group col-sm-2" style="width: 100px;height: 300px;">
                            <textarea style="min-height:270px;min-width:320px;max-height:270px;max-width:320px;">{{print_r($request_data,true)}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">查询响应数据：</label>
                        <div class="input-group col-sm-2" style="width: 100px;height: 300px;">
                            <textarea style="min-height:270px;min-width:320px;max-height:270px;max-width:320px;">{{print_r($retrieve_req_data,true)}}</textarea>
                        </div>
                    </div>
                    <div class="hr-line-dashed m-t-sm m-b-sm"></div>
            </div>
        </div>
    </div>
@endsection
