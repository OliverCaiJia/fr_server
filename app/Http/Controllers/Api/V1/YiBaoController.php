<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\RestResponseFactory;
use App\Helpers\RestUtils;
use App\Http\Controllers\Api\ApiController;
use App\Models\Factory\Api\AccountFactory;
use App\Models\Factory\Api\InviteFactory;
use Illuminate\Http\Request;


class YiBaoController extends ApiController
{
    /**
     * 获取账户信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public  function sync(Request $request)
    {
        $params = $request->input();
        file_put_contents('1.txt',$params);die;
//        $uid = $this->getUserId($request);
//        $account = AccountFactory::fetchUserAccount($uid);
//        return RestResponseFactory::ok($account);
    }

    public function async(Request $request)
    {
        $params = $request->input();
        file_put_contents('2.txt',$params);die;
        $uid = $this->getUserId($request);
        $UserOrder = InviteFactory::fetchUserInvitations($uid);
        return RestResponseFactory::ok($UserOrder);
    }
}