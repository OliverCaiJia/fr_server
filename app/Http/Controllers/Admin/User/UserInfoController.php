<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\Orm\UserInfo;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

class UserInfoController extends AdminController
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
    public function update(Request $request, $id)
    {

        $user = UserInfo::findOrFail($id);
        $userData = [
            'status' => $request->input('status'),
            'has_userinfo' => $request->input('has_userinfo'),
            'service_status' => $request->input('service_status'),
            'update_at' => date('Y-m-d H:i:s')
        ];
        $user->update($userData);

        return redirect()->route('admin.userinfo.index', ['id' => $id])->with('success', '修改成功');
    }


}
