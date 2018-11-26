<?php

namespace App\Strategies;

/**
 * @author zhaoqiying
 */
use App\Constants\CreditConstant;
use App\Helpers\RestUtils;
use App\Strategies\AppStrategy;
use App\Models\Orm\UserInfo;
use App\Models\Orm\UserOrder;

class UserStatusStrategy extends AppStrategy
{
    /**判断用户认证状态
     * @param $uid
     * @return array
     */
    public static function getUserInfo($uid)
    {
        $userStatus = UserInfo::select(['service_status', 'has_userinfo'])->where(['user_id' => $uid])->first();

        return $userStatus ? $userStatus->toArray() : [];
    }

    public static function getOrder($uid)
    {
        $data = UserOrder::where(['user_id' => $uid])->first();

        return $data ? 1 : 0;
    }

}
