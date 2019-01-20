<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\Orm\UserAuth;
use App\Models\Orm\UserBasic;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

class UserBasicController extends AdminController
{
    /**
     * 用户个人资料
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //查询条件
        $username = $request->input('user_name');

        $userIds = $query = UserAuth::when($username, function ($query) use ($username) {
            return $query->where('user_name', $username);
        })->pluck('id');

        $query = new UserBasic();
        if ($userIds) {
            $query = $query->whereIn('user_id', $userIds);
        }

        $query = $query->orderBy('id', 'desc')->paginate(10);

        return view('admin.users.userbasic.index', compact('query'));
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
