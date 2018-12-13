<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\Orm\UserAuth;
use App\Models\Orm\UserInviteCode;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

class UserInviteCodeController extends AdminController
{
    /**
     * 用户生成邀请码页.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //查询条件
        $username = $request->input('user_name');

        $userIds = UserAuth::when($username, function ($query) use ($username) {
            return $query->where('user_name', 'like', '%' . $username . '%');
        })->pluck('id');

        $query = new UserInviteCode();
        if ($userIds) {
            $query = $query->whereIn('user_id', $userIds);
        }
        $query = $query->orderBy('id', 'desc')->paginate(10);

        return view('admin.users.userinvitecode.index', compact('query'));
    }

    /**
     * 编辑页.
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = UserInviteCode::findOrFail($id);

        return view('admin.users.userinvitecode.edit', compact('user'));
    }

    /**
     * 更新用户信息
     *
     * @param \Illuminate\Http\Request $request
     * @param                          $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = UserInviteCode::findOrFail($id);
        $userData = [
            'status' => $request->input('status'),
            'update_at' => date('Y-m-d H:i:s')
        ];
        $user->update($userData);

        return redirect()->route('admin.userinvitecode.index', ['id' => $id])->with('success', '修改成功');
    }
}
