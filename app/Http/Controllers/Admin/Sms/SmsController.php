<?php

namespace App\Http\Controllers\Admin\Sms;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Orm\SmsLog;
use Illuminate\Http\Request;
use Excel;

class SmsController extends AdminController
{


    /**
     * 订单记录
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //查询条件
        $mobile = $request->input('mobile');

        $query = SmsLog::when($mobile,function ($query) use($mobile){
            return $query->where('mobile', '=', $mobile);
        })->orderBy('id', 'desc')->paginate(20);
        return view('admin.sms.index', compact('query'));
    }

    /**删除
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $sms = SmsLog::where('id', $id)->findOrFail($id);
        $sms->delete();

        return redirect()->route('admin.sms.index')->with('success', '删除成功！');
    }

}
