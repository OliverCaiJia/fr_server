@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox-title">
                <h5>用户个人信息管理</h5>
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
                            {{--<div class="form-group">--}}
                            {{--<label for="status">状态:</label>--}}
                            {{--<select class="form-control m-b" name="status">--}}
                            {{--<option>{{Request::input('status')}}</option>--}}
                            {{--<option @if(Request::input('status') == '') selected @endif value=''>全部</option>--}}
                            {{--<option @if(Request::input('status') == 0) selected @endif  value='0'>无效</option>--}}
                            {{--<option @if(Request::input('status') == 1) selected @endif value='1'>有效</option>--}}
                            {{--</select>--}}
                            {{--</div>--}}
                            {{--<div class="form-group">--}}
                            {{--<label for="service_status">服务状态:</label>--}}
                            {{--<select class="form-control m-b" name="service_status">--}}
                            {{--<option @if(Request::input('service_status') == '') selected @endif value=''>全部</option>--}}
                            {{--<option @if(Request::input('service_status') == 0) selected @endif value='0'>未认证</option>--}}
                            {{--<option @if(Request::input('service_status') == 1) selected @endif value='1'>身份认证</option>--}}
                            {{--<option @if(Request::input('service_status') == 2) selected @endif value='2'>绑定银行卡</option>--}}
                            {{--<option @if(Request::input('service_status') == 3) selected @endif value='3'>信用报告</option>--}}
                            {{--<option @if(Request::input('service_status') == 4) selected @endif value='4'>申请贷款</option>--}}
                            {{--<option @if(Request::input('service_status') == 5) selected @endif value='5'>增值服务</option>--}}
                            {{--</select>--}}
                            {{--</div>--}}
                            {{--<div class="form-group">--}}
                            {{--<label for="has_userinfo">用户资料:</label>--}}
                            {{--<select class="form-control m-b" name="has_userinfo">--}}
                            {{--<option @if(Request::input('has_userinfo') == '') selected @endif value=''>全部</option>--}}
                            {{--<option @if(Request::input('has_userinfo') == 0) selected @endif  value='0'>未填写</option>--}}
                            {{--<option @if(Request::input('has_userinfo') == 1) selected @endif value='1'>已填写</option>--}}
                            {{--</select>--}}
                            {{--</div>--}}
                            <button type="submit" class="btn btn-sm btn-primary"> 搜索</button>
                            <button class="btn btn-white btn-sm" type="button" onclick="refresh()">清空</button>
                        </form>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover m-t-md" data-mobile-responsive="true">
                    {{--                    @if($orders->total()) style="width: 2000px" @endif>--}}
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>用户名</th>
                        <th>城市</th>
                        <th>用户所在地</th>
                        <th>用户详细地址</th>
                        <th>职业</th>
                        <th>企业执照</th>
                        <th>工作时间</th>
                        <th>工资发放</th>
                        <th>工资收入</th>
                        <th>芝麻分</th>
                        <th>公积金</th>
                        <th>社保</th>
                        <th>房</th>
                        <th>车</th>
                        <th>保险</th>
                        <th>微粒贷</th>
                        <th>创建时间</th>
                        <th>更新时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($query as $k => $item)
                        <tr>
                            <td style="word-break:break-all;max-width:350px;">{{$item->id}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{App\Models\Factory\Admin\Users\UsersFactory::getUsername($item->user_id)}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->city}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->user_location}}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->user_address}}</td>
                            <td style="word-break:break-all;max-width:350px;">
                                @if($item->status == 0)
                                    <span style="color: green;font-weight: bold;">上班族</span>
                                @elseif($item->status == 1)
                                    <span style="color : green;font-weight: bold">公务员</span>
                                @elseif($item->status == 2)
                                    <span style="color : green;font-weight: bold">企业主</span>
                                @elseif($item->status == 3)
                                    <span style="color : green;font-weight: bold">自由职业</span>
                                @endif
                            </td>
                            <td style="word-break:break-all;max-width:350px;">
                                @if($item->company_license_time == 0)
                                    <span style="color: red;font-weight: bold;">一年以内</span>
                                @elseif($item->company_license_time == 1)
                                    <span style="color : green;font-weight: bold">一年以上</span>
                                @endif
                            </td>
                            <td style="word-break:break-all;max-width:350px;">
                                @if($item->work_time == 0)
                                    <span style="color: green;font-weight: bold;">半年以内</span>
                                @elseif($item->work_time == 1)
                                    <span style="color : green;font-weight: bold">一年以内</span>
                                @elseif($item->work_time == 2)
                                    <span style="color : green;font-weight: bold">一年以上</span>

                                @endif
                            </td>
                            <td style="word-break:break-all;max-width:350px;">
                                @if($item->salary_deliver == 1)
                                    <span style="color: green;font-weight: bold;">银行转账</span>
                                @elseif($item->salary_deliver == 2)
                                    <span style="color : green;font-weight: bold">现金发放</span>
                                @endif
                            </td>
                            <td style="word-break:break-all;max-width:350px;">
                                @if($item->month_salary == 0)
                                    <span style="color: red;font-weight: bold;">两千以下</span>
                                @elseif($item->month_salary == 1)
                                    <span style="color : green;font-weight: bold">2-5千</span>
                                @elseif($item->month_salary == 2)
                                    <span style="color : green;font-weight: bold">5k-1W</span>
                                @elseif($item->month_salary == 3)
                                    <span style="color : green;font-weight: bold">1w以上</span>
                                @endif
                            </td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->zhima_score or ''}}</td>
                            <td style="word-break:break-all;max-width:350px;">
                                @if($item->house_fund_time == 0)
                                    <span style="color: green;font-weight: bold;">无公积金</span>
                                @elseif($item->house_fund_time == 1)
                                    <span style="color : green;font-weight: bold">一年以内</span>
                                @elseif($item->house_fund_time == 2)
                                    <span style="color : green;font-weight: bold">一年以上</span>
                                @endif
                            </td>
                            <td style="word-break:break-all;max-width:350px;">
                                @if($item->has_social_security == 0)
                                    <span style="color: red;font-weight: bold;">没有</span>
                                @elseif($item->has_social_security == 1)
                                    <span style="color : green;font-weight: bold">有</span>
                                @endif
                            </td>
                            <td style="word-break:break-all;max-width:350px;">
                                @if($item->has_house == 0)
                                    <span style="color: red;font-weight: bold;">没有</span>
                                @elseif($item->has_house == 1)
                                    <span style="color : green;font-weight: bold">有</span>
                                @endif
                            </td>
                            <td style="word-break:break-all;max-width:350px;">
                                @if($item->has_auto == 0)
                                    <span style="color: red;font-weight: bold;">没有</span>
                                @elseif($item->has_auto == 1)
                                    <span style="color : green;font-weight: bold">有</span>
                                @endif
                            </td>
                            <td style="word-break:break-all;max-width:350px;">
                                @if($item->has_assurance == 0)
                                    <span style="color: red;font-weight: bold;">没有</span>
                                @elseif($item->has_assurance == 1)
                                    <span style="color : green;font-weight: bold">有</span>
                                @endif
                            </td>
                            <td style="word-break:break-all;max-width:350px;">
                                @if($item->has_weilidai == 0)
                                    <span style="color: red;font-weight: bold;">没有</span>
                                @elseif($item->has_weilidai == 1)
                                    <span style="color : green;font-weight: bold">有</span>
                                @endif
                            </td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->create_at }}</td>
                            <td style="word-break:break-all;max-width:350px;">{{$item->update_at}}</td>
                            <td>
                                <a href="{{--{{ route('admin.userinfo.edit', ['id' => $item->id]) }}--}}">
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
