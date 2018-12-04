<?php

namespace App\Http\Controllers\Admin\User;

use App\Events\OperationLogEvent;
use App\Http\Requests\UserRequest;
use App\Models\Orm\UserBorrowLog;
use App\Models\Orm\SaasPerson;
use App\Http\Controllers\Admin\User\ViewController;
use Illuminate\Http\Request;

class UserBorrowController extends ViewController
{
    /**用户贷款流水
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $query = UserBorrowLog::orderBy('id', 'desc')->paginate(10);

        return view('admin.users.userborrow.index', compact('query'));
    }


    /**删除
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $borrow = UserBorrowLog::where('id', $id)->findOrFail($id);
        $borrow->delete();

        return redirect()->route('admin.userborrow.index')->with('success', '删除成功！');
    }

}
