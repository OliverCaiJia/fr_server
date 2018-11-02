@extends('layouts.layout')
@section('content')
    @include('admin.common.status')
    <form id="form" action="{{ Request::url() }}" method="post">
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-sm-8">
                <div class="form-group">
                    <label>旧密码 *</label>
                    <input id="oldPass" name="old_pass" type="password" class="form-control" required="">
                    @if ($errors->has('old_pass'))
                        <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('old_pass')}}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label>新密码 *</label>
                    <input id="password" name="password" type="password" class="form-control" required="">
                    @if ($errors->has('password'))
                        <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('password')}}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label>确认密码 *</label>
                    <input id="confirm" name="password_confirmation" type="password" class="form-control" required="">
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <button type="submit" class="btn btn-sm btn-primary"> 提交</button>
        </div>
    </form>
@endsection
