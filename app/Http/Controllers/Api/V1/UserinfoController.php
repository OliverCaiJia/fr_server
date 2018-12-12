<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Http\HttpClient;
use App\Helpers\Logger\SLogger;
use App\Helpers\RestResponseFactory;
use App\Http\Controllers\Api\ApiController;
use App\Models\Factory\Api\UserBasicFactory;
use App\Models\Factory\Api\FreeOrderFactory;
use App\Models\Factory\Api\UserBorrowLogFactory;
use App\Models\Factory\Api\UserAuthFactory;
use App\Helpers\RestUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserInfoController extends ApiController
{
    //face++
    public function fetchUserInfo()
    {
        $res = [];
        return RestResponseFactory::ok($res);
    }

    /**创建修改个人资料
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCertifyinfo(Request $request)
    {
        $uid = $this->getUserId($request);
        $data = $request->all();
//        $data = [
//            'profession' => '0',
//            'company_name' => '智借网络',
//            'company_location' => '北京市',
//            'company_address' => '北京市海淀区苏州街',
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
        SLogger::getStream()->info(print_r($data, true));
        $UserBasic = UserBasicFactory::createOrUpdateUserBasic($data, $uid);
        if ($UserBasic) {
            return RestResponseFactory::ok($data);
        } else {
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(2101), 2101);
        }
    }

    /**个人资料查询
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchCertifyinfo(Request $request)
    {
        $uid = $this->getUserId($request);
        $data = UserBasicFactory::fetchUserBasic($uid);
        if (empty($data)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1005), 1005);
        }
        return RestResponseFactory::ok($data);
    }

    /**
     * 点击去借钱修改状态
     */
    public function freeOrder(Request $request)
    {
        $uid = $this->getUserId($request);
        $data = FreeOrderFactory::Order($uid);
        if (empty($data)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1005), 1005);
        }
        return RestResponseFactory::ok($data);
    }

    /**首页获取用户所选金额周期
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userQuota(Request $request)
    {
        $uid = $this->getUserId($request);
        $amount = $request->all();
        $data = UserBorrowLogFactory::createUserBorrowLog($uid, $amount);
        if (empty($data)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1005), 1005);
        }
        return RestResponseFactory::ok($data);
    }
}
