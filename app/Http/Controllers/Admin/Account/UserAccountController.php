<?php

namespace App\Http\Controllers\Admin\Account;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Models\Orm\UserAccount;

class UserAccountController extends AdminController
{
    /**用户贷款流水
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = UserAccount::orderBy('id', 'desc')->paginate(10);

        return view('admin.payment.useraccount.index', compact('query'));
    }

    /**
     * 编辑页
     * @param Request $request
     * @return type
     */
    public function edit($id)
    {
        $user = UserAccount::findOrFail($id);

        return view('admin.payment.useraccount.edit', compact('user'));
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
