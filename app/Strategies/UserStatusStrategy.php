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
use App\Models\Orm\UserOrderType;
use App\Helpers\RestResponseFactory;

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
        $data = UserOrder::where(['user_id' => $uid, 'order_type' => 2])->first();

        return $data ? 1 : 0;
    }

    public static function paidOrder($uid)
    {
        $userStatus = self::getUserInfo($uid);
        if ($userStatus['service_status'] == 4) {
            $userOrder = UserOrder::select(['order_no', 'order_type', 'create_at', 'amount', 'term', 'status'])->where(['user_id' => $uid, 'status' => 1])->first()->toArray();
            $url = UserOrderType::select(['logo_url'])->where(['id' => $userOrder['order_type']])->first();
            $userOrder['logo_url'] = $url->logo_url;
            return $userOrder;
        } else {
            return  null;
        }
    }

}
