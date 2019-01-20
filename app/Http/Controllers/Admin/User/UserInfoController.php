<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\Orm\UserInfo;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

class UserInfoController extends AdminController
{
    /**
     * 用户个人信息列表页.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //查询条件
        $status = $request->input('status');
        $service_status = $request->input('service_status');
        $has_userinfo = $request->input('has_userinfo');

        $query = new UserInfo();

        if ($has_userinfo || $has_userinfo === '0') {
            $query = $query->where('has_userinfo', $has_userinfo);
        }

        if ($status || $status === '0') {
            $query = $query->where('status', $status);
        }

        if ($service_status || $service_status === '0') {
            $query = $query->where('service_status', $service_status);
        }

        $query = $query->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.users.userinfo.index', compact('query'));
    }

    /**
     * 修改用户个人信息页.
     *
     * @param integer $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = UserInfo::findOrFail($id);

        return view('admin.users.userinfo.edit', compact('user'));
    }

    /**
     * 更新用户信息.
     *
     * @param \Illuminate\Http\Request $request
     * @param                          $id
     *
     * @return \Illuminate\Http\RedirectResponse
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
