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
                            {{--<div class="form-group">--}}
                                {{--<label for="username">渠道标识:</label>--}}
                                {{--<input placeholder="手机号" name="mobile" class="form-control input-sm"--}}
                                       {{--autocomplete="off" id="mobile" value="{{Request::input("channel") }}">--}}
                            {{--</div>--}}
                            <button type="submit" class="btn btn-sm btn-primary"> 搜索</button>
                            <button class="btn btn-white btn-sm" type="button" onclick="refresh()">清空</button>
                        </form>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover m-t-md" data-mobile-responsive="true">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>渠道标识</th>
                        <th>渠道名称</th>
                        <th>状态</th>
                        <th>渠道统计</th>
                        <th>创建时间</th>
                        <th>更新时间</th>
                        {{--<th>操作</th>--}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($query as $k => $item)
                        <tr>
                            <td style="word-break:break-all;max-width:350px;">{{ $item->id }}</td>
                            <td style="word-break:break-all;max-width:350px;">{{ App\Models\Factory\Admin\Channel\ChannelFactory::getTypeNid($item->channel_id) }}</td>
                            <td style="word-break:break-all;max-width:350px;">{{ App\Models\Factory\Admin\Channel\ChannelFactory::getTypeName($item->channel_id) }}</td>
                            <td style="word-break:break-all;max-width:350px;">
                                @if($item->status == 0)
                                    <span style="color: red;font-weight: bold;">无效</span>
                                @elseif($item->status == 1)
                                    <span style="color : green;font-weight: bold">有效</span>
                                @endif
                            </td>
                            <td style="word-break:break-all;max-width:350px;">{{ App\Models\Factory\Admin\Channel\ChannelFactory::getCount($item->channel_id) }}</td>
                            <td style="word-break:break-all;max-width:350px;">{{ $item->create_at }}</td>
                            <td style="word-break:break-all;max-width:350px;">{{ $item->update_at }}</td>
                            {{--<td>--}}
                                {{--<a href="--}}{{--{{ route('admin.smstype.edit', ['id' => $item->id]) }}--}}{{--">--}}
                                    {{--<button class="btn btn-primary btn-xs" type="button">--}}
                                        {{--<i class="fa fa-paste"></i> 修改--}}
                                    {{--</button>--}}
                                {{--</a>--}}
                                {{--<form action="{{ route('admin.smstype.destroy', ['id' => $item->id]) }}" method="post"--}}
                                      {{--class="inline">--}}
                                    {{--{{ csrf_field() }}--}}
                                    {{--{{ method_field('DELETE') }}--}}
                                    {{--<button class="btn btn-danger btn-xs" type="submit">--}}
                                        {{--<i class="fa fa-trash-o"></i> 删除--}}
                                    {{--</button>--}}
                                {{--</form>--}}
                            {{--</td>--}}
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
        $('#name').val('{{ Request::input('name') }}');
        $('#username').val('{{ Request::input('username') }}');

        function refresh() {
            document.getElementById("myform").reset();
            $('#myform').submit();
        }
    </script>
@endsection
