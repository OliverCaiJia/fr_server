@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox-title">
                <h5>修改管理员</h5>
            </div>
            @include('admin.common.status')
            <div class="ibox-content">
                <a href="{{route('admin.user.index')}}"><button class="btn btn-primary btn-sm" type="button"><i class="fa fa-home"></i>返回管理员列表</button></a>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <form class="form-horizontal m-t-md" action="{{ route('admin.user.update', ['id' => $user->id]) }}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">姓名(*)：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="name" value="{{ $user->name }}" required data-msg-required="请输入姓名">
                            @if ($errors->has('name'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('name')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">手机号：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="mobilephone" value="{{ $user->mobilephone }}">
                            @if ($errors->has('mobilephone'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{ $errors->first('mobilephone')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">部门(*)：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="department" value="{{ $user->department }}" required data-msg-required="请输入部门">
                            @if ($errors->has('department'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('department')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">职位：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="position" value="{{ $user->position }}">
                            @if ($errors->has('position'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('position')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">邮箱：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="email" value="{{ $user->email }}">
                            @if ($errors->has('email'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('email')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">帐户名(*)：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="username" value="{{ $user->username }}" required data-msg-required="请输入帐户名">
                            @if ($errors->has('username'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('username')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">角色(*)：</label>
                        <div class="input-group col-sm-2">
                            <select class="form-control m-b" name="role">
                                <option value="">请选择</option>
                                @foreach($roles as $key => $role)
                                    <option value="{{ $key }}" @if($key == $roleId) selected @endif>{{ $role }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('role'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('role')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">密码：</label>
                        <div class="input-group col-sm-2">
                            <input type="password" class="form-control" name="password" data-msg-required="请输入密码">
                            @if ($errors->has('password'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('password')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">确认密码：</label>
                        <div class="input-group col-sm-2">
                            <input type="password" class="form-control" name="password_confirmation" data-msg-required="请输入密码">
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
