<?php

namespace App\Http\Controllers\Admin\Config;

use App\Models\Orm\UserInviteConfig;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

class InviteConfigController extends AdminController
{
    /**用户贷款流水
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = UserInviteConfig::orderBy('id', 'desc')->paginate(10);

        return view('admin.config.inviteconfig.index', compact('query'));
    }


    /**删除
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $user = UserInviteConfig::findOrFail($id);

        return view('admin.config.inviteconfig.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = UserInviteConfig::findOrFail($id);
        $userData = [
            'title'=>$request->input('title'),
            'content'=>$request->input('content'),
            'logo'=>$request->input('logo'),
            'status' => $request->input('status'),
            'update_at' => date('Y-m-d H:i:s')
        ];
        $user->update($userData);

        return redirect()->route('admin.inviteconfig.index', ['id' => $id])->with('success', '修改成功');
    }

}
