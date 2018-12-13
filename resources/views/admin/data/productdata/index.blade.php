@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox-title">
                <h5>渠道数据</h5>
            </div>
            @include('admin.common.status')
            <div class="ibox-content">
                <div class="col-sm-3">
                </div>
                <div class="row">
                    <div class="col-sm-8" style="text-align: right">
                        <form action="{{ Request::url() }}" class="form-inline" method="get" id="myform">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            {{--<div class="form-group">--}}
                                {{--<label for="name">渠道:</label>--}}
                                {{--<select class="form-control m-b" name="channel_title">--}}

                                    {{--@foreach ($channel as $k => $item)--}}
                                        {{--<option value="{{$item->id}}">{{$item->channel_title }}</option>--}}
                                    {{--@endforeach--}}
                                {{--</select>--}}
                            {{--</div>--}}
                            <div class="form-group">
                                <label for="username">用户名:</label>
                                <input placeholder="用户名" name="mobile" class="form-control input-sm"
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
                        <th>产品ID</th>
                        <th>产品URL</th>
                        <th>渠道</th>
                        <th>创建时间</th>
                        <th>更新时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($query as $k => $item)
                        <tr>
                            <td style="word-break:break-all;max-width:350px;">{{ $item->id }}</td>
                            <td style="word-break:break-all;max-width:350px;">{{App\Models\Factory\Admin\Users\UsersFactory::getUsername($item->user_id)}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->product_id}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->product_url}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->channel_id}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{ $item->create_at }}</td>
                            <td style="word-break:break-all;max-width:350px;">{{ $item->update_at }}</td>
                            <td>
                                <a href="{{ route('admin.productdata.edit', ['id' => $item->id]) }}">
                                    <button class="btn btn-primary btn-xs" type="button">
                                        <i class="fa fa-paste"></i> 详情
                                    </button>
                                </a>
                                {{--<form action="{{ route('admin.smstype.destroy', ['id' => $item->id]) }}" method="post"--}}
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
                {{$query->links()}}
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
@endsection

@section('js')
    <script>
        $('#mobile').val('{{ Request::input('mobile') }}');
        {{--$('#username').val('{{ Request::input('username') }}');--}}

        function refresh() {
            document.getElementById("myform").reset();
            $('#myform').submit();
        }
    </script>
@endsection
