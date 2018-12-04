@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox-title">
                <h5>修改用户</h5>
            </div>
            @include('admin.common.status')
            <div class="ibox-content">
                <a href="{{route('admin.useraccountlog.index')}}"><button class="btn btn-primary btn-sm" type="button"><i class="fa fa-home"></i>返回用户列表</button></a>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
{{--                <form class="form-horizontal m-t-md" action="{{ route('admin.useraccount.update', $user->id) }}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">--}}
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">用户名：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{App\Models\Factory\Admin\Users\UsersFactory::getUsername($user->user_id)}}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('user_name'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('user_name')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">交易号：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="nid_no" value="{{$user->nid_no }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('nid_no'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('nid_no')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">类型：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->type }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('user_name'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('user_name')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">操作金额：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->money }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('money'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('money')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">变化总金额：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->total }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('total'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('total')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">上次总金额：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->total_old }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('total_old'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('total_old')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">这次总金额：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->total_new }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('total_new'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('total_new')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">收入：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->income }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('income'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('income')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">上次总收入：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->income_old }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('income_old'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('income_old')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">当前总收入：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->income_new }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('income_new'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('income_new')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">支出：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->expend }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('expend'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('expend')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">上次总支出：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->expend_old }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('expend_old'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('expend_old')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">当前总支出：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->expend_new }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('expend_new'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('expend_new')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">可用余额变化：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->balance }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('balance'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('balance')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">旧的可用余额：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->balance_old }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('balance_old'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('balance_old')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">最新的金额：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->balance_new }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('balance_new'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('balance_new')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">提现金额：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->balance_cash }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('balance_cash'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('balance_cash')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">上次可提现金额：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->balance_cash_old }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('balance_cash_old'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('balance_cash_old')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">当前可提现金额：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->balance_cash_new }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('balance_cash_new'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('balance_cash_new')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">不可提现冻结金额：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->balance_frost }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('balance_frost'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('balance_frost')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">上次不可提现冻结金额：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->balance_frost_old }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('balance_frost_old'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('balance_frost_old')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">当前不可提现冻结金额：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->balance_frost_new }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('balance_frost_new'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('balance_frost_new')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">冻结金额：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->frost }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('frost'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('frost')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">冻结旧金额：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->frost_old }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('frost_old'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('frost_old')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">新的冻结金额：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->frost_new }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('frost_new'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('frost_new')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">冻结提现金额：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->frost_cash }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('frost_cash'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('frost_cash')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">冻结提现旧金额：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->frost_cash_old }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('frost_cash_old'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('frost_cash_old')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">新的提现冻结金额：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->frost_cash_new }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('frost_cash_new'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('frost_cash_new')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">其他冻结金额：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->frost_other }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('frost_other'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('frost_other')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">其他冻结旧金额：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->frost_other_old }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('frost_other_old'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('frost_other_old')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">其他新的冻结金额：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->frost_other_new }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('frost_other_new'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('frost_other_new')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">待收金额：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->await }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('await'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('await')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">旧的待收余额：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->await_old }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('await_old'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('await_old')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">新的待收余额：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->await_new }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('await_new'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('await_new')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">待还金额：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->repay }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('repay'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('repay')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">旧的待还金额：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->repay_old }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('repay_old'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('repay_old')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">新的待还金额：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="user_name" value="{{$user->repay_new }}" required data-msg-required="请输入姓名"  readonly="readonly">
                            @if ($errors->has('repay_new'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('repay_new')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                    <div class="form-group">
                        {{--<div class="col-sm-12 col-sm-offset-2">--}}
                            {{--<button class="btn btn-primary" type="submit"><i class="fa fa-check"></i>&nbsp;保 存</button>--}}
                        {{--</div>--}}
                    </div>
                    <div class="clearfix"></div>
                {{--</form>--}}
            </div>
        </div>
    </div>
@endsection
