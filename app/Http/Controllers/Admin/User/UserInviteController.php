<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\Orm\UserInvite;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

class UserInviteController extends AdminController
{
    /**邀请好友
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //查询条件

        $query = UserInvite::orderBy('id', 'desc')->paginate(10);

        return view('admin.users.userinvite.index', compact('query'));
    }

    /**编辑页
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = UserInvite::findOrFail($id);

        return view('admin.users.userinvite.edit', compact('user'));
    }

    /**更新用户信息
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = UserInvite::findOrFail($id);
        $userData = [
            'status' => $request->input('status'),
            'update_at' => date('Y-m-d H:i:s')
        ];
        $user->update($userData);

        return redirect()->route('admin.userinvite.index', ['id' => $id])->with('success', '修改成功');
    }

}
