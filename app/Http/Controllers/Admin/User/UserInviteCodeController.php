<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\Orm\UserInviteCode;
use App\Http\Controllers\Admin\User\ViewController;
use Illuminate\Http\Request;

class UserInviteCodeController extends ViewController
{
    /**注册用户
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //查询条件
//        $status = $request->input('status');
//        $service_status = $request->input('service_status');
//        $has_userinfo = $request->input('has_userinfo');

        $query = UserInviteCode::orderBy('id', 'desc')->paginate(10);

        return view('admin.users.userinvitecode.index', compact('query'));
    }

    /**
     * 编辑页
     * @param Request $request
     * @return type
     */
    public function edit($id)
    {
        $user = UserInviteCode::findOrFail($id);

        return view('admin.users.userinvitecode.edit', compact('user'));
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
        $user = UserInviteCode::findOrFail($id);
        $userData = [
            'status' => $request->input('status'),
            'update_at' => date('Y-m-d H:i:s')
        ];
        $user->update($userData);

        return redirect()->route('admin.userinvitecode.index', ['id' => $id])->with('success', '修改成功');
    }

}
