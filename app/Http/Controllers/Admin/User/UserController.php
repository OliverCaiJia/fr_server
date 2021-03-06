<?php

namespace App\Http\Controllers\Admin\User;

use App\Events\OperationLogEvent;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\Factory\Admin\Saas\SaasPersonFactory;
use App\Models\Orm\UserAuth;
use App\Models\Orm\AdminPersons;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

class UserController extends AdminController
{
    /**
     * 注册用户
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //查询条件
        $mobile = $request->input('mobile');
        $username = $request->input('user_name');

        $query = UserAuth::when($mobile, function ($query) use ($mobile) {
            return $query->where('mobile', '=', $mobile);
        })->when($username, function ($query) use ($username) {
            return $query->where('user_name', 'like', '%' . $username . '%');
        })->orderBy('id', 'desc')->paginate(10);

        return view('admin.users.index', compact('query'));
    }

    /**
     * 编辑页
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = UserAuth::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * 更新用户信息
     *
     *  @param Request $request
     * @param                                $id
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = UserAuth::findOrFail($id);

        $userData = [
            'status' => $request->input('status'),
            'last_login_at' => date('Y-m-d H:i:s')
        ];
        $user->update($userData);

        return redirect()->route('admin.user.index', ['id' => $id])->with('success', '修改成功');
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
        $user = AdminPersons::where('saas_auth_id', Auth::user()->saas_auth_id)->findOrFail($id);
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
