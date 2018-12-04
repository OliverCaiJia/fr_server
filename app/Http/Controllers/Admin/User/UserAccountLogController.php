<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Admin\User\ViewController;
use Illuminate\Http\Request;
use App\Models\Orm\UserAccountLog;

class UserAccountLogController extends ViewController
{
    /**用户贷款流水
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = UserAccountLog::orderBy('id', 'desc')->paginate(10);

        return view('admin.users.useraccountlog.index', compact('query'));
    }

    /**
     * 编辑页
     * @param Request $request
     * @return type
     */
    public function edit($id)
    {
        $user = UserAccountLog::findOrFail($id);

        return view('admin.users.useraccountlog.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = UserAccount::findOrFail($id);
        $userData = [
            'status' => $request->input('status'),
            'update_at' => date('Y-m-d H:i:s')
        ];
        $user->update($userData);

        return redirect()->route('admin.useraccount.index', ['id' => $id])->with('success', '修改成功');
    }

}
