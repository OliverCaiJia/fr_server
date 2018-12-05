@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox-title">
                <h5>修改用户</h5>
            </div>
            @include('admin.common.status')
            <div class="ibox-content">
                <a href="{{route('admin.user.index')}}"><button class="btn btn-primary btn-sm" type="button"><i class="fa fa-home"></i>返回用户列表</button></a>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <form class="form-horizontal m-t-md" action="{{ route('admin.user.update', $user->id) }}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">用户名：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{ $user->user_name }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('user_name'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('user_name')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">手机号：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="mobile" value="{{ $user->mobile }}"  readonly="readonly">
                            @if ($errors->has('mobile'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{ $errors->first('mobile')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">用户状态：</label>
                        <div class="input-group col-sm-2">
                            <select class="form-control m-b" name="status" value="{{$item->status or '' }}">
                                <option  @isset($user->status) @if($user->status == '0') selected @endif @endisset value='0'>未激活</option>
                                <option  @isset($user->status) @if($user->status == '1') selected @endif @endisset value='1'>激活</option>
                                <option  @isset($user->status) @if($user->status == '2') selected @endif @endisset value='2'>锁定</option>
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
