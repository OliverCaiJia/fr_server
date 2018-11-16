<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\RestResponseFactory;
use App\Helpers\RestUtils;
use App\Http\Controllers\Api\ApiController;
use App\Models\Factory\Api\AccountFactory;
use App\Models\Factory\Api\InviteFactory;
use Illuminate\Http\Request;


class AccountController extends ApiController
{
    /**
     * 获取账户信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public  function info(Request $request)
    {
        $uid = $this->getUserId($request);
        $account = AccountFactory::fetchUserAccount($uid);
        return RestResponseFactory::ok($account);
    }

    public function inviteAccount(Request $request)
    {
        $uid = $this->getUserId($request);
        $UserOrder = InviteFactory::fetchUserInvitations($uid);
        return RestResponseFactory::ok($UserOrder);
    }
}