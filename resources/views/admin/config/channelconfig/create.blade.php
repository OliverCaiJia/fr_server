@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox-title">
                <h5>添加渠道配置</h5>
            </div>
            <div class="ibox-content">
                <a class="menuid btn btn-primary btn-sm" href="javascript:history.go(-1)">返回</a>
                <a href="{{ route('admin.channelconfig.index') }}"><button class="btn btn-primary btn-sm" type="button"><i class="fa fa-home"></i> 渠道列表</button></a>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <form class="form-horizontal m-t-md" action="{{ route('admin.channelconfig.store') }}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">渠道标识：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="channel_nid" value="" required data-msg-required="请输入短信类型标识">
                            @if ($errors->has('channel_nid'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('channel_nid')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">渠道名称：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="channel_title" value="">
                            @if ($errors->has('channel_title'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('channel_title')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">渠道描述：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="channel_des" value="" required data-msg-required="请输入短信类型描述">
                            @if ($errors->has('channel_des'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('channel_des')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">状态：</label>
                        <div class="input-group col-sm-2">
                            <label><input name="status" type="radio" value="1" />有效 </label>
                            <label><input name="status" type="radio" value="0" />无效 </label>

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
