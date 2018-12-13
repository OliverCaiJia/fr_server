@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox-title">
                <h5>管理员管理</h5>
            </div>
            @include('admin.common.status')
            <div class="ibox-content">
                <div class="col-sm-3">
                    <a href="{{ route('admin.person.create') }}" link-url="javascript:void(0)">
                        <button class="btn btn-primary btn-sm" type="button">
                            <i class="fa fa-plus-circle"></i> 添加管理员
                        </button>
                    </a>
                </div>
                <div class="row">
                    <div class="col-sm-8" style="text-align: right">
                        <form action="{{ Request::url() }}" class="form-inline" method="get" id="myform">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="name">姓名:</label>
                                <input placeholder="姓名" name="name" class="form-control input-sm" autocomplete="off" id="name">
                            </div>
                            <div class="form-group">
                                <label for="username">账户名:</label>
                                <input placeholder="账户名" name="username" class="form-control input-sm" autocomplete="off" id="username">
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
                        <th>姓名</th>
                        {{--<th>邮箱</th>--}}
                        <th>账户名</th>
                        {{--<th>部门</th>--}}
                        {{--<th>职位</th>--}}
                        <th>角色</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $k => $item)
                        <tr>
                            <td>{{App\Helpers\Utils::generalAutoIncrementId($users, $loop)}}</td>
                            <td>{{$item->name}}</td>
{{--                            <td>{{$item->email}}</td>--}}
                            <td>{{$item->username}}</td>
{{--                            <td>{{$item->department}}</td>--}}
{{--                            <td>{{$item->position}}</td>--}}
                            <td>{{ App\Models\Factory\Admin\Saas\SaasPersonFactory::getFirstRoleById($item->id) }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.person.edit', ['id' => $item->id]) }}">
                                        <button class="btn btn-primary btn-xs" type="button">
                                            <i class="fa fa-paste"></i> 修改
                                        </button>
                                    </a>
                                    <form action="{{ route('admin.person.destroy', ['id' => $item->id]) }}" method="post" class="inline">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-danger btn-xs" type="submit">
                                            <i class="fa fa-trash-o"></i> 删除
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$users->links()}}
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
@endsection

@section('js')
    <script>
        $('#name').val('{{ Request::input('name') }}');
        $('#username').val('{{ Request::input('username') }}');
        function refresh() {
            document.getElementById("myform").reset();
            $('#myform').submit();
        }
    </script>
@endsection
