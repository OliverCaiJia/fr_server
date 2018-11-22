<?php

namespace App\Strategies;

/**
 * @author zhaoqiying
 */
use App\Constants\CreditConstant;
use App\Helpers\RestUtils;
use App\Strategies\AppStrategy;
use App\Models\Orm\UserInfo;

class UserStatusStrategy extends AppStrategy
{
    /**判断用户认证状态
     * @param $uid
     * @return array
     */
    public static function getUserInfo($uid)
    {
        $userStatus = UserInfo::select(['service_status', 'has_userinfo'])->where(['user_id' => $uid])->get()->toArray();

        return $userStatus ? $userStatus : [];
    }

}
