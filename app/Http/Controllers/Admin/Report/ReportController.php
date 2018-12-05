<?php

namespace App\Http\Controllers\Admin\Report;

use App\Models\Orm\UserReport;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;

class ReportController extends AdminController
{
    /**信用报告
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //查询条件
//        $mobile = $request->input('mobile');
//        $username = $request->input('user_name');
//

        $query = UserReport::orderBy('id', 'desc')->paginate(10);

        return view('admin.report.index', compact('query'));
    }

    /**
     * 编辑页
     * @param Request $request
     * @return type
     */
    public function edit($id)
    {
        $report = UserReport::findOrFail($id);
        $request_data = json_decode($report->report_data,true);

        return view('admin.report.edit', compact('request_data'));
    }


}
