<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\RestResponseFactory;
use App\Helpers\RestUtils;
use App\Http\Controllers\Api\ApiController;
use App\Models\Factory\Api\AccountFactory;
use Illuminate\Http\Request;


class AccountController extends ApiController
{
    /**
     * 获取账户信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function info(Request $request)
    {
        $data = $request->all();
        $account = AccountFactory::fetchUserAccount($data['user_id']);
        return RestResponseFactory::ok($account);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $params = [];
        $create = AccountFactory::createAccountLog($params);
        if (empty($create)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1401), 1401);
        } else {
            return RestResponseFactory::ok();
        }
//        return RestResponseFactory::ok();
    }


    public function status()
    {
        return RestResponseFactory::ok();
    }
}