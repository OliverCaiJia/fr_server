<?php

namespace App\Http\Controllers\Admin\Account;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Models\Orm\UserAccountLog;

class UserAccountLogController extends AdminController
{

    /**
     * 用户贷款流水
     * @param Request $request
     * @return type
     */
    public function edit($id)
    {
        $query = UserAccountLog::where(['user_id' => $id])->orderBy('id', 'desc')->paginate(10);

        return view('admin.payment.useraccountlog.index', compact('query'));

//        return view('admin.payment.useraccountlog.edit', compact('user'));
    }


}
