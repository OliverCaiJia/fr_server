@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox-title">
                <h5>添加短信配置</h5>
            </div>
            <div class="ibox-content">
                <a class="menuid btn btn-primary btn-sm" href="javascript:history.go(-1)">返回</a>
                <a href="{{ route('admin.smstype.index') }}"><button class="btn btn-primary btn-sm" type="button"><i class="fa fa-home"></i> 短信列表</button></a>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <form class="form-horizontal m-t-md" action="{{ route('admin.smstype.store') }}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">短信类型标识：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="message_type_nid" value="" required data-msg-required="请输入短信类型标识">
                            @if ($errors->has('message_type_nid'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('message_type_nid')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">短信类型名称：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="message_type_name" value="">
                            @if ($errors->has('message_type_name'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('message_type_name')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">短信类型描述：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="message_type_desc" value="" required data-msg-required="请输入短信类型描述">
                            @if ($errors->has('message_type_desc'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('message_type_desc')}}</span>
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
