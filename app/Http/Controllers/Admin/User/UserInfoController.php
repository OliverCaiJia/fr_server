<?php

namespace App\Http\Controllers\Admin\User;

use App\Events\OperationLogEvent;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserRequest;
use App\Models\Factory\Admin\Saas\SaasPersonFactory;
use App\Models\Factory\Admin\Saas\SaasRoleFactory;
use App\Models\Orm\UserAuth;
use App\Models\Orm\UserInfo;
use App\Models\Orm\SaasPerson;
use App\Http\Controllers\Admin\User\ViewController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Hash;

class UserInfoController extends ViewController
{
    /**注册用户
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //查询条件
        $status = $request->input('status');
        $service_status = $request->input('service_status');
        $has_userinfo = $request->input('has_userinfo');

        $query = UserInfo::when($status, function ($query) use ($status) {
            return $query->where('status', '=', $status);
        })->when($service_status, function ($query) use ($service_status) {
            return $query->where('service_status', '=', $service_status);
        })->when($has_userinfo, function ($query) use ($has_userinfo) {
            return $query->where('has_userinfo', '=', $has_userinfo);
        })->orderBy('id', 'desc')->paginate(10);

        return view('admin.users.userinfo.index', compact('query'));
    }

    /**
     * 编辑页
     * @param Request $request
     * @return type
     */
    public function edit($id)
    {
        $user = UserInfo::findOrFail($id);

        return view('admin.users.userinfo.edit', compact('user'));
    }

    /**
     * 更新用户信息
     *
     * @param \App\Http\Requests\UserRequest $request
     * @param                                $id
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, $id)
    {

        dd($id);
        $user = SaasPerson::where('saas_auth_id', Auth::user()->saas_auth_id)->findOrFail($id);
        $password = $request->input('password');

        $userData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'department' => $request->input('department'),
            'position' => $request->input('position'),
            'username' => $request->input('username'),
            'mobilephone' => $request->input('mobilephone')
        ];
        $userData = $password ? array_merge($userData, ['password' => bcrypt($password)]) : $userData;

        $user->update($userData);

        if ($request->input('role')) {
            $user->roles()->sync($request->input('role'));
        } else {
            $user->roles()->detach();
        }
        event(new OperationLogEvent(12, json_encode($user->toArray())));

        return redirect()->route('admin.user.edit', ['id' => $id])->with('success', '修改成功');
    }

    /**
     * 删除用户及关联角色数据
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = SaasPerson::where('saas_auth_id', Auth::user()->saas_auth_id)->findOrFail($id);
        //检查是否有子用户
        if (SaasPersonFactory::getAllPersonByPersonId($user->id)) {
            return redirect()->back()->with('error', '该账户有下级账户, 不能删除!');
        }
        //是否有分配的订单
        if (SaasOrderFactory::getByPersonId($user->id)) {
            return redirect()->back()->with('error', '该账户有分配的订单, 不能删除!');
        }

        $user->where('id', $id)->update(['is_deleted' => 1]);
        $user->roles()->detach();
        event(new OperationLogEvent(11, json_encode($user->toArray())));

        return redirect()->route('admin.user.index', ['id' => $id])->with('success', '删除成功');
    }

    /**
     * 修改登陆密码
     *
     * @param ChangePasswordRequest $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function changePsw(ChangePasswordRequest $request)
    {
        if ($request->isMethod('POST')) {
            $personId = Auth::user()->id;
            $personInfo = SaasPersonFactory::getPersonInfo($personId);

            if (Hash::check($request->input('old_pass'), $personInfo->password)) {
                $result = SaasPersonFactory::changePsw($personId, $request->input('password'));
            } else {
                return redirect()->back()->with('error', '输入的旧密码有误！');
            }

            if ($result) {
                event(new OperationLogEvent(200, $request->input('password')));
                return redirect()->back()->with('success', '成功！');
            }

            return redirect()->back()->with('error', '失败!');
        }

        return view('admin.changepsw');
    }
}
