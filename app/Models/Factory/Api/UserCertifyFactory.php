<?php

namespace App\Models\Factory\Api;

use App\Helpers\Utils;
use App\Models\Orm\UserCertify;
use App\Models\Orm\UserRealname;


class UserCertifyFactory extends ApiFactory
{
    /**
     * 获取用户认证信息
     * @param $userId
     * @return array
     */
    public static function fetchUserCertify($userId)
    {
        $userCertify = UserCertify::select()
            ->where(['user_id' => $userId])
            ->first();

        return $userCertify ? $userCertify->toArray() : [];
    }

}