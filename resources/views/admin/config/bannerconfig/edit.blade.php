@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox-title">
                <h5>修改用户</h5>
            </div>
            @include('admin.common.status')
            <div class="ibox-content">
                <a href="{{route('admin.bannerconfig.index')}}">
                    <button class="btn btn-primary btn-sm" type="button"><i class="fa fa-home"></i>返回用户列表</button>
                </a>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <form class="form-horizontal m-t-md" action="{{ route('admin.bannerconfig.update', $user->id) }}"
                      method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">banner名称：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="banner_name" value="{{$user->banner_name}}"
                                   required
                                   data-msg-required="请输入姓名">
                            @if ($errors->has('banner_name'))
                                <span class="help-block m-b-none"><i
                                            class="fa fa-info-circle"></i>{{$errors->first('banner_name')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">图片地址：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="img_address" value="{{$user->img_address }}"
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
                            <input type="text" class="form-control" name="img_href" value="{{$user->img_href }}"
                                   required
                                   data-msg-required="请输入姓名" style="width: 450px">
                            @if ($errors->has('img_href'))
                                <span class="help-block m-b-none"><i
                                            class="fa fa-info-circle"></i>{{$errors->first('img_href')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">状态：</label>
                        <div class="input-group col-sm-2">
                            <select class="form-control m-b" name="status" value="{{$item->status or '' }}">
                                <option @isset($user->status) @if($user->status == '0') selected
                                        @endif @endisset value='0'>
                                    无效
                                </option>
                                <option @isset($user->status) @if($user->status == '1') selected
                                        @endif @endisset value='1'>
                                    有效
                                </option>
                            </select>
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
