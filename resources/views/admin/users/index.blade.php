@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox-title">
                <h5>用户中心</h5>
            </div>
            @include('admin.common.status')
            <div class="ibox-content">
                <div class="col-sm-3">
                    {{--<a href="{{ route('admin.user.create') }}" link-url="javascript:void(0)">--}}
                        {{--<button class="btn btn-primary btn-sm" type="button">--}}
                            {{--<i class="fa fa-plus-circle"></i> 添加管理员--}}
                        {{--</button>--}}
                    {{--</a>--}}
                </div>
                <div class="row">
                    <div class="col-sm-8" style="text-align: right">
                        <form action="{{ Request::url() }}" class="form-inline" method="get" id="myform">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="name">用户名:</label>
                                <input placeholder="用户名" name="user_name" class="form-control input-sm"
                                       autocomplete="off"
                                       id="user_name">
                            </div>
                            <div class="form-group">
                                <label for="username">手机号:</label>
                                <input placeholder="手机号" name="mobile" class="form-control input-sm"
                                       autocomplete="off" id="mobile">
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary"> 搜索</button>
                            <button class="btn btn-white btn-sm" type="button" onclick="refresh()">清空</button>
                        </form>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover m-t-md" data-mobile-responsive="true">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>用户名</th>
                        <th>手机号</th>
                        <th>用户状态</th>
                        <th>创建时间</th>
                        <th>最后登录时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($query as $k => $item)
                        <tr>
                            <td style="word-break:break-all;max-width:350px;">{{$item->id}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->user_name}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->mobile}}</td>
                            <td style="word-break:break-all;max-width:350px;">
                                @if($item->status == 0)
                                    <span style="color: red;font-weight: bold;">未激活</span>
                                @elseif($item->status == 1)
                                    <span style="color : green;font-weight: bold">激活</span>
                                @elseif($item->status == 2)
                                    <span style="color: red;font-weight: bold;">锁定</span>
                                @endif
                            </td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->create_at or ''}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->last_login_at or ''}}</td>
                            <td>
                                <a href="{{ route('admin.user.edit', ['id' => $item->id]) }}">
                                    <button class="btn btn-primary btn-xs" type="button">
                                        <i class="fa fa-paste"></i> 修改
                                    </button>
                                </a>
                                {{--<form action="{{ route('admin.role.destroy', ['id' => $item->id]) }}" method="post"--}}
                                      {{--class="inline">--}}
                                    {{--{{ csrf_field() }}--}}
                                    {{--{{ method_field('DELETE') }}--}}
                                    {{--<button class="btn btn-danger btn-xs" type="submit">--}}
                                        {{--<i class="fa fa-trash-o"></i> 删除--}}
                                    {{--</button>--}}
                                {{--</form>--}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$query->appends([
                'user_name' => Request::input('user_name'),
                'mobile' => Request::input('mobile')
                ])->links()}}
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
@endsection

@section('js')
    <script>
        $('#user_name').val('{{ Request::input('user_name') }}');
        $('#mobile').val('{{ Request::input('mobile') }}');

        function refresh() {
            document.getElementById("myform").reset();
            $('#myform').submit();
        }
    </script>
@endsection
