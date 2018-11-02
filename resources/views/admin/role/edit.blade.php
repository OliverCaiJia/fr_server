@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="ibox-title">
            <h5>添加角色</h5>
        </div>
        @include('admin.common.status')
        <div class="ibox-content">
            <a href="{{route('admin.role.index')}}"><button class="btn btn-primary btn-sm" type="button"><i class="fa fa-home"></i>返回角色管理</button></a>
            <div class="hr-line-dashed m-t-sm m-b-sm"></div>
            <form class="form-horizontal m-t-md" action="{{route('admin.role.update',$role->id)}}" method="post">
                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label class="col-sm-2 control-label">角色名称：</label>
                    <div class="input-group col-sm-2">
                        <input type="text" class="form-control" name="name" value="{{$role->name}}" required data-msg-required="请输入角色名称">
                        @if ($errors->has('name'))
                            <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('name')}}</span>
                        @endif
                    </div>
                </div>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">角色描述：</label>
                    <div class="input-group col-sm-3">
                        <input name="description" class="form-control" rows="5" cols="20" required data-msg-required="请输入角色描述" value="{{ $role->description }}">
                        @if ($errors->has('description'))
                            <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('description')}}</span>
                        @endif
                    </div>
                </div>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <div class="form-group">
                    @if($permissionAll)
                        @foreach($permissionAll[0] as $v)
                            <div class="form-group">
                                <label class="control-label col-md-2 all-check">
                                    {{$v['label']}}：
                                </label>
                                <div class="col-md-6" id="container">
                                    @if(isset($permissionAll[$v['id']]))
                                        @foreach($permissionAll[$v['id']] as $vv)
                                            <div class="col-md-4" style="float:left;padding-left:20px;margin-top:8px;">
                                                <span class="checkbox-custom checkbox-default">
                                                    <i class="fa"></i>
                                                        <input class="form-actions"
                                                               @if(in_array($vv['id'],$permissions))
                                                               checked
                                                               @endif
                                                               id="inputChekbox{{$vv['id']}}" type="Checkbox" value="{{$vv['id']}}"
                                                               name="permissions[]">
                                                        <label for="inputChekbox{{$vv['id']}}">
                                                            {{$vv['label']}}
                                                        </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </span>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
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
