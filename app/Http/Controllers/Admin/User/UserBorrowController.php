<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\Orm\UserAuth;
use App\Models\Orm\UserBorrowLog;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

class UserBorrowController extends AdminController
{
    /**
     * 用户贷款流水页.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //查询条件
        $mobile = $request->input('mobile');
        $username = $request->input('user_name');

        $userIds = $query = UserAuth::when($mobile, function ($query) use ($mobile) {
            return $query->where('mobile', $mobile);
        })->when($username, function ($query) use ($username) {
            return $query->where('user_name', 'like', '%' . $username . '%');
        })->pluck('id');

        $query = new UserBorrowLog();
        if ($userIds) {
            $query = $query->whereIn('user_id', $userIds);
        }

        $query = $query->orderBy('id', 'desc')->paginate(10);


        return view('admin.users.userborrow.index', compact('query'));
    }


    /**删除
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $borrow = UserBorrowLog::where('id', $id)->findOrFail($id);
        $borrow->delete();

        return redirect()->route('admin.userborrow.index')->with('success', '删除成功！');
    }
}
