<?php

namespace App\Http\Controllers\Admin\Account;

use App\Models\Orm\PaymentLog;
use App\Models\Orm\UserAuth;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

class PaymentAccountController extends AdminController
{
    /**信用报告
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //查询条件
        $id = '';
        $username = $request->input('user_name');
        if ($username) {
            $user = UserAuth::where(['user_name' => $username])->first();
            $id = $user->id;
        }
//
        $query = PaymentLog::when($id, function ($query) use ($id) {
            return $query->where('user_id', '=', $id);
        })->orderBy('id', 'desc')->paginate(10);

        return view('admin.payment.index', compact('query'));
    }

    /**
     * 编辑页
     * @param Request $request
     * @return type
     */
    public function edit($id)
    {
        $report = PaymentLog::findOrFail($id);
        $request_data = json_decode($report->request_data, true);
        $response_data = json_decode($report->response_data, true);

        return view('admin.payment.edit', compact('request_data', 'response_data', 'report'));
    }


}
