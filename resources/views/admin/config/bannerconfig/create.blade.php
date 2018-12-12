@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox-title">
                <h5>添加banner配置</h5>
            </div>
            <div class="ibox-content">
                <a class="menuid btn btn-primary btn-sm" href="javascript:history.go(-1)">返回</a>
                <a href="{{ route('admin.bannerconfig.index') }}">
                    <button class="btn btn-primary btn-sm" type="button"><i class="fa fa-home"></i> banner列表</button>
                </a>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <form class="form-horizontal m-t-md" action="{{ route('admin.bannerconfig.store') }}" method="post"
                      accept-charset="UTF-8" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">banner名称：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="banner_name" value="" required
                                   data-msg-required="请输入banner名称">
                            @if ($errors->has('banner_name'))
                                <span class="help-block m-b-none"><i
                                            class="fa fa-info-circle"></i>{{$errors->first('banner_name')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">banner类型名称：</label>
                            <select class="input-group col-sm-2" name="banner_type_id">
                                @foreach ($banner_type as $k => $item)
                                    <option value="{{$item['id']}}">{{$item['type']}}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">序号：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="position" value="">
                            @if ($errors->has('position'))
                                <span class="help-block m-b-none"><i
                                            class="fa fa-info-circle"></i>{{$errors->first('position')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">图片地址：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="img_address" value=""
                                   required
                                   data-msg-required="请输入姓名" style="width: 450px">
                            @if ($errors->has('img_address'))
                                <span class="help-block m-b-none"><i
                                            class="fa fa-info-circle"></i>{{$errors->first('img_address')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">图片链接：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="img_href" value=""
                                   required
                                   data-msg-required="请输入姓名" style="width: 450px">
                            @if ($errors->has('img_href'))
                                <span class="help-block m-b-none"><i
                                            class="fa fa-info-circle"></i>{{$errors->first('img_href')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">链接类型：</label>
                            <select class="input-group col-sm-2" name="link_type">
                                @foreach ($link_type as $k => $item)
                                    <option value="{{$item['id']}}">{{$item['name']}}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">状态：</label>
                        <div class="input-group col-sm-2">
                            <label><input name="status" type="radio" value="1"/>有效 </label>
                            <label><input name="status" type="radio" value="0"/>无效 </label>

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
