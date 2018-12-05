@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox-title">
                <h5>修改用户</h5>
            </div>
            @include('admin.common.status')
            <div class="ibox-content">
                <a href="{{route('admin.inviteconfig.index')}}">
                    <button class="btn btn-primary btn-sm" type="button"><i class="fa fa-home"></i>返回用户列表</button>
                </a>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <form class="form-horizontal m-t-md" action="{{ route('admin.inviteconfig.update', $user->id) }}"
                      method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">title：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="title" value="{{$user->title}}" required data-msg-required="请输入姓名" style="width: 450px">
                            @if ($errors->has('title'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('title')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">内容：</label>
                        <div class="input-group col-sm-2">
                            <textarea style="min-height:270px;min-width:320px;max-height:270px;max-width:320px;">{{$user->content}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">logo：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="logo" value="{{$user->logo }}"
                                   required
                                   data-msg-required="请输入姓名" style="width: 450px">
                            @if ($errors->has('logo'))
                                <span class="help-block m-b-none"><i
                                            class="fa fa-info-circle"></i>{{$errors->first('logo')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">状态：</label>
                        <div class="input-group col-sm-2">
                            <select class="form-control m-b" name="status" value="{{$item->status or '' }}">
                                <option @isset($user->status) @if($user->status == '0') selected
                                        @endif @endisset value='0'>
                                    开启
                                </option>
                                <option @isset($user->status) @if($user->status == '1') selected
                                        @endif @endisset value='1'>
                                    关闭
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
