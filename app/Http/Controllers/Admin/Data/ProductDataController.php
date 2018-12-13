<?php

namespace App\Http\Controllers\Admin\Data;

use App\Models\Orm\UserApplyLog;
use App\Models\Factory\Api\UserAuthFactory;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

class ProductDataController extends AdminController
{
    /**用户贷款流水
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //查询条件
        $mobile = $request->input('mobile');
        $id = UserAuthFactory::getUserIdByMobile($mobile);

        $query = UserApplyLog::when($id, function ($query) use ($id) {
            return $query->where('user_id', $id);
        })->orderBy('id', 'desc')->paginate(10);
        return view('admin.data.productdata.index', compact('query'));
    }


    /**
     * 详情
     * @param Request $request
     * @return type
     */
    public function edit($id)
    {
        $user = UserApplyLog::findOrFail($id);
        $response_data = json_decode($user->response_data,true);

        return view('admin.data.productdata.edit', compact('response_data'));
    }

}
