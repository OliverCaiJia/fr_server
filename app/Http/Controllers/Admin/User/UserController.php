<?php

namespace App\Http\Controllers\Admin\User;

use App\Events\OperationLogEvent;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserRequest;
use App\Models\Factory\Admin\Saas\SaasPersonFactory;
use App\Models\Factory\Admin\Saas\SaasRoleFactory;
use App\Models\Orm\UserAuth;
use App\Models\Orm\SaasPerson;
use App\Http\Controllers\Admin\User\ViewController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Hash;

class UserController extends ViewController
{
    /**注册用户
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $requests = $this->getRequests($request);
//        //查询条件
        $mobile = $request->input('mobile');
        $username = $request->input('user_name');
//
        $query = UserAuth::when($mobile, function ($query) use ($mobile) {
            return $query->where('mobile', $mobile);
        })->when($username, function ($query) use ($username) {
            return $query->where('user_name', 'like',  '%' . $username . '%');
        });

        $total = $query->count('id');
        $results = $query->offset($requests['pageSize'] * ($requests['pageCurrent'] - 1))
            ->orderBy($requests['orderField'], $requests['orderDirection'])
            ->limit($requests['pageSize'])
            ->get()->toArray();

        return view('admin.users.index',[
            'items' => $results,
            'total' => $total,
            'pageSize' => $requests['pageSize'],
            'pageCurrent' => $requests['pageCurrent']
            ]);
    }

    /**
     * 编辑页
     * @param Request $request
     * @return type
     */
    public function edit(Request $request)
    {
        $id = $request->get('id');
        print_r($id);die;
        $user = UserAuth::find($id);
        if ($this->isPostMethod($request))
        {
            $user->type_id = $request->input('type_id', '0');
            $user->type_nid = $request->input('type_nid', '');
            $user->name = $request->input('name');
            $user->remark = $request->input('remark');
            $user->status = $request->input('status', 0);
            $user->pending = $request->input('pending', 0);
            $user->updated_at = date('Y-m-d H:i:s', time());
            $user->updated_id = $request->user()->id;
            if ($user->save())
            {
                return AdminResponseFactory::ok('operate-config');
            }
        }
        // 数据
        $item = $model->toArray();
        $types = SpreadMarketFactory::getTypes();
        return view('admin_modules.operate.config.edit', [
            'item' => $item,
            'types' => $types
        ]);
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
