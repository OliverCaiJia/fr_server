<?php

namespace App\Http\Controllers\Admin\Account;

use App\Models\Orm\PaymentLog;
use App\Models\Factory\Api\UserAuthFactory;
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
        $mobile = $request->input('mobile');
        $status = $request->input('status');
//        print_r($status);
        $id = UserAuthFactory::getUserIdByMobile($mobile);

        $query = new PaymentLog();

        if ($status || $status === '0') {
            $query = $query->where('status', $status);
        }

        $query = $query->when($id, function ($query) use ($id) {
            return $query->where('user_id', $id);
        })->orderBy('id', 'desc')->paginate(10);

return view('admin.payment.index', compact('query'));
}

/**
 * 编辑页
 * @param Request $request
 * @return type
 */
public
function edit($id)
{
    $report = PaymentLog::findOrFail($id);
    $request_data = $report->request_data;
    $response_data = $report->response_data;

    return view('admin.payment.edit', compact('request_data', 'response_data', 'report'));
}


}
