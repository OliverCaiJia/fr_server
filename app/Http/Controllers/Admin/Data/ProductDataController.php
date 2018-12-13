<?php

namespace App\Http\Controllers\Admin\Data;

use App\Models\Orm\UserApplyLog;
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
//        $channel_title = $request->input('channel_title');

        $query = UserApplyLog::orderBy('id', 'desc')->paginate(10);
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
