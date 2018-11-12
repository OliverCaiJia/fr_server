<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Http\HttpClient;
use App\Helpers\RestResponseFactory;
use App\Http\Controllers\Api\ApiController;
use App\Models\Factory\Api\UserBasicFactory;
use App\Helpers\RestUtils;
use Illuminate\Http\Request;

class UserInfoController extends ApiController
{
    //face++
    public function fetchUserInfo()
    {
        $res = [];
        return RestResponseFactory::ok($res);
    }

    public function updateCertifyinfo(Request $request)
    {
        $data = $request->all();
//        $data = [
//            'user_id' => '1',
//            'profession' => '0',
//            'company_name' => '智借网络',
//            'company_location' => '北京',
//            'company_address' => '苏州街',
//            'work_time' => '1',
//            'month_salary' => '3',
//            'zhima_score' => '667',
//            'house_fund_time' => '2',
//            'has_social_security' => '0',
//            'has_house' => '1',
//            'has_auto' => '0',
//            'has_house_fund' => '1',
//            'has_assurance' => '1',
//            'has_weilidai' => '0',
//            'create_at' => '2018-11-12 15:41:16',
//            'update_at' => '2018-11-12 15:41:16',
//        ];
        $UserBasic = UserBasicFactory::UserBasic($data);
        if ($UserBasic) {
            return RestResponseFactory::ok($data);
        } else {
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(2101), 2101);
        }
    }

    public function fetchCertifyinfo(Request $request)
    {
        $userId = $request->input('user_id');
        $data = UserBasicFactory::fetchUserBasic($userId);
        if (empty($data)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1005), 1005);
        }
        return RestResponseFactory::ok($data);
    }
}