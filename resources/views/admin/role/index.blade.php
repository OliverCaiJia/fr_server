@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox-title">
                <h5>角色管理</h5>
            </div>
            @include('admin.common.status')
            <div class="ibox-content">
                <a href="{{ route('admin.role.create') }}" link-url="javascript:void(0)">
                    <button class="btn btn-primary btn-sm" type="button">
                        <i class="fa fa-plus-circle"></i> 添加角色
                    </button>
                </a>
                <table class="table table-striped table-bordered table-hover m-t-md" data-mobile-responsive="true">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>名称</th>
                        <th>描述</th>
                        <th>创建时间</th>
                        <th>修改时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $k => $item)
                        <tr>
                            <td>{{App\Helpers\Utils::generalAutoIncrementId($roles, $loop)}}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->updated_at }}</td>
                            <td>
                                <a href="{{ route('admin.role.edit', ['id' => $item->id]) }}">
                                    <button class="btn btn-primary btn-xs" type="button">
                                        <i class="fa fa-paste"></i> 修改
                                    </button>
                                </a>
                                <form action="{{ route('admin.role.destroy', ['id' => $item->id]) }}" method="post" class="inline">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-danger btn-xs" type="submit">
                                        <i class="fa fa-trash-o"></i> 删除
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $roles->links() }}
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
@endsection
