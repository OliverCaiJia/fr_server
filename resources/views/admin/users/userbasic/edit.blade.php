@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox-title">
                <h5>修改用户</h5>
            </div>
            @include('admin.common.status')
            <div class="ibox-content">
                <a href="{{route('admin.userinfo.index')}}"><button class="btn btn-primary btn-sm" type="button"><i class="fa fa-home"></i>返回上层列表</button></a>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <form class="form-horizontal m-t-md" action="{{ route('admin.userinfo.update', $user->id) }}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">用户名：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{App\Models\Factory\Admin\Users\UsersFactory::getUsername($user->user_id)}}" required data-msg-required=""  readonly="readonly">
                            @if ($errors->has('user_id'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('user_id')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">状态：</label>
                        <div class="input-group col-sm-2">
                            <select class="form-control m-b" name="status" value="{{$item->status or '' }}">
                                <option  @isset($user->status) @if($user->status == '0') selected @endif @endisset value='0'>无效</option>
                                <option  @isset($user->status) @if($user->status == '1') selected @endif @endisset value='1'>有效</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">用户资料：</label>
                        <div class="input-group col-sm-2">
                            <select class="form-control m-b" name="has_userinfo" value="{{$item->has_userinfo or '' }}">
                                <option  @isset($user->has_userinfo) @if($user->has_userinfo == '0') selected @endif @endisset value='0'>未填写</option>
                                <option  @isset($user->has_userinfo) @if($user->has_userinfo == '1') selected @endif @endisset value='1'>已填写</option>
                            </select>
                        </div>
                    </div>
                    <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">服务状态：</label>
                        <div class="input-group col-sm-2">
                            <select class="form-control m-b" name="service_status" value="{{$item->service_status or '' }}">
                                <option  @isset($user->service_status) @if($user->service_status == '0') selected @endif @endisset value='0'>未认证</option>
                                <option  @isset($user->service_status) @if($user->service_status == '1') selected @endif @endisset value='1'>身份认证</option>
                                <option  @isset($user->service_status) @if($user->service_status == '2') selected @endif @endisset value='2'>绑定银行卡</option>
                                <option  @isset($user->service_status) @if($user->service_status == '3') selected @endif @endisset value='3'>信用报告</option>
                                <option  @isset($user->service_status) @if($user->service_status == '4') selected @endif @endisset value='4'>申请贷款</option>
                                <option  @isset($user->service_status) @if($user->service_status == '5') selected @endif @endisset value='5'>增值服务</option>
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
