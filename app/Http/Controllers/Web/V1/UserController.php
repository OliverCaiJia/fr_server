<?php

namespace App\Http\Controllers\Web\V1;

use App\Models\Factory\Api\UserBasicFactory;
use Illuminate\Http\Request;
use App\Http\Controllers\Web\WebController;

class UserController extends WebController
{

    public function report(Request $request)
    {
        $data = [];
        return view('web.user.report', $data);
    }

    public function createReport()
    {
        return view('web.user.createreport');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userinfo(Request $request)
    {
        echo 111;die;
        $user_id = $this->getUserId($request);
        $data = UserBasicFactory::fetchUserBasic($user_id);
        $token = $this->getToken($request);

        if(empty($data)){
            return view('web.user.userinfo', compact('data','token'));
        }
        switch ($data['profession']){
            case 0:
                $data['profession'] = '上班族';
                break;
            case 1:
                $data['profession'] = '企业主';
                break;
            case 2:
                $data['profession'] = '自由职业';
        }

        switch ($data['work_time']){
            case 0:
                $data['work_time'] = '半年内';
                break;
            case 1:
                $data['work_time'] = '一年以内';
                break;
            case 2:
                $data['work_time'] = '一年以上';
        }

        switch ($data['month_salary']){
            case 0:
                $data['month_salary'] = '2千以下';
                break;
            case 1:
                $data['month_salary'] = '2千-5千';
                break;
            case 2:
                $data['month_salary'] = '5千-1万';
                break;
            case 4:
                $data['month_salary'] = '1万以上';
                break;
        }

        switch ($data['house_fund_time']){
            case 0:
                $data['house_fund_time'] = '无公积金';
                break;
            case 1:
                $data['house_fund_time'] = '一年以内';
                break;
            case 2:
                $data['house_fund_time'] = '一年以上';
                break;
        }
        return view('web.user.userinfo', compact('data','token'));
    }
}
