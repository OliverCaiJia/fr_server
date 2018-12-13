@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox-title">
                <h5>修改渠道配置</h5>
            </div>
            @include('admin.common.status')
            <div class="ibox-content">
                <a href="{{route('admin.channelconfig.index')}}"><button class="btn btn-primary btn-sm" type="button"><i class="fa fa-home"></i>返回上层列表</button></a>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <form class="form-horizontal m-t-md" action="{{ route('admin.channelconfig.update', $user->id) }}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">渠道标识：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="channel_nid" value="{{$user->channel_nid }}" required data-msg-required=""  readonly="readonly">
                            @if ($errors->has('channel_nid'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('channel_nid')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">渠道名称：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="channel_title" value="{{$user->channel_title }}" required data-msg-required="" >
                            @if ($errors->has('channel_title'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('channel_title')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">状态：</label>
                        <div class="input-group col-sm-2">
                            <select class="form-control m-b" name="status" value="{{$user->status or '' }}">
                                <option  @isset($user->status) @if($user->status == '0') selected @endif @endisset value='0'>无效</option>
                                <option  @isset($user->status) @if($user->status == '1') selected @endif @endisset value='1'>有效</option>
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
