<?php

namespace App\Http\Controllers\Admin\Saas;

use App\Constants\SaasConstant;
use App\Events\OperationLogEvent;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserRequest;
use App\Models\Factory\Admin\Order\OrderFactory;
use App\Models\Factory\Admin\Order\SaasOrderFactory;
use App\Models\Factory\Admin\Saas\SaasPersonFactory;
use App\Models\Factory\Admin\Saas\SaasRoleFactory;
use App\Models\Orm\SaasOrderSaas;
use App\Models\Orm\SaasPerson;
use App\Strategies\SaasPersonStrategy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Hash;

class UserController extends Controller
{
    /**
     * 管理员列表
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //查询条件
        $name = $request->input('name');
        $username = $request->input('username');

        $users = SaasPerson::when($name, function ($query) use ($name) {
            return $query->where('name', $name);
        })->when($username, function ($query) use ($username) {
            return $query->where('username', $username);
        });

        $authUser = Auth::user();
        $users = $users->where('is_deleted', 0)
            ->where('saas_auth_id', $authUser->saas_auth_id)
            ->where('id', '!=', $authUser->id);

        if (!$authUser->super_user) {
            $ids = SaasPersonStrategy::getSubIdsById($authUser->id);
            $users = $users->whereIn('id', $ids);
        }

        $users = $users->orderBy('id', 'desc')->paginate(10);

        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        $roles = SaasRoleFactory::getBySaasAuthId(Auth::user()->saas_auth_id);

        return view('admin.user.create', compact('roles'));
    }

    /**
     * 存储管理员
     *
     * @param \App\Http\Requests\UserRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $authUser = Auth::user();
        $user = SaasPerson::updateOrCreate([
            'username' => $request->input('username'),
            'is_deleted' => SaasConstant::SAAS_USER_DELETED_TRUE
        ], [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'department' => $request->input('department'),
            'position' => $request->input('position'),
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password')),
            'saas_auth_id' => $authUser->saas_auth_id,
            'create_id' => $authUser->id,
            'is_deleted' => SaasConstant::SAAS_USER_DELETED_FALSE,
            'mobilephone' => $request->input('mobilephone')
        ]);

        $user->roles()->attach($request->input('role'));
        event(new OperationLogEvent(10, json_encode($user->toArray())));

        return redirect()->route('admin.user.index')->with('success', '添加成功！');
    }

    public function edit($id)
    {
        $saasAuthId = Auth::user()->saas_auth_id;
        $user = SaasPerson::where('saas_auth_id', $saasAuthId)->findOrFail($id);

        $roleId = $user->roles->first()->id;
        $roles = SaasRoleFactory::getBySaasAuthId($saasAuthId);

        return view('admin.user.edit', compact('user', 'roleId', 'roles'));
    }

    /**
     * 更新管理员信息
     *
     * @param \App\Http\Requests\UserRequest $request
     * @param                                $id
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, $id)
    {
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
