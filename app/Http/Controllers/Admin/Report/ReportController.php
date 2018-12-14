<?php

namespace App\Http\Controllers\Admin\Report;

use App\Models\Factory\Api\UserAuthFactory;
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
        $mobile = $request->input('mobile');
        $report_code = $request->input('report_code');

        //查询手机号
        $user_id = UserAuthFactory::getUserIdByMobile($mobile);

        //获取列表信息
        $query = UserReport::when($user_id, function ($query) use ($user_id) {
            return $query->where('user_id', $user_id);
        })->when($report_code, function ($query) use ($report_code) {
            return $query->where('report_code', $report_code);
        })->orderBy('id', 'desc')->paginate(10);

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
        $request_data = $report->report_data;
        $requestData = json_decode($request_data);
        $postLoad = $requestData->post_load;
        $antiFraud = $requestData->anti_fraud;
        $blackGray = $requestData->black_gray;
        $multiInfo = $requestData->multi_info;
        $application = $requestData->application;
        $creditEvaluation = $requestData->credit_evaluation;
        $creditQualification = $requestData->credit_qualification;

//        dd($postLoad->trans_id);

        $transId = $postLoad->trans_id;


        return view('admin.report.edit', compact('request_data'));
    }

    /**
     * 报告详情页
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id)
    {
        $report = UserReport::findOrFail($id);
        $request_data = $report->report_data;
        $requestData = json_decode($request_data);
        $postLoad = $requestData->post_load;
        $antiFraud = $requestData->anti_fraud;
        $blackGray = $requestData->black_gray;
        $multiInfo = $requestData->multi_info;
        $application = $requestData->application;
        $creditEvaluation = $requestData->credit_evaluation;
        $creditQualification = $requestData->credit_qualification;

//        dd($request_data);

        $transId = $postLoad->trans_id;


        return view('admin.report.detail', compact('request_data', 'postLoad'));
    }
}
