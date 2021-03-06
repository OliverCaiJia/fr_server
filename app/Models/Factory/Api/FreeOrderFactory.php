<?php

namespace App\Models\Factory\Api;

use App\Helpers\Logger\SLogger;
use App\Models\Factory\Api\ApiFactory;
use App\Strategies\UserOrderStrategy;
use App\Models\Orm\UserOrder;
use App\Models\Orm\UserOrderType;
use App\Models\Orm\UserLoanTask;
use App\Models\Orm\UserInfo;
use App\Helpers\Utils;

/**
 * Class FreeOrderFactory
 * @package App\Models\Factory\Api
 */
class FreeOrderFactory extends ApiFactory
{
    public static function Order($uid)
    {
        $orderStatus = UserLoanTask::where(['user_id' => $uid, 'status' => 0])->first();
        //不等于空修改状态
        if (!empty($orderStatus)) {
            $orderStatus->status = 1;
            $orderStatus->update_at = date('Y-m-d H:i:s');
            $orderStatus->save();
        }
        $userInfo = UserInfo::where(['user_id' => $uid, 'service_status' => 3])->first();
        if (!empty($userInfo)) {
            $userInfo->service_status = 4;
            $userInfo->update_at = date('Y-m-d H:i:s');
            $userInfo->save();
        }
        $typeId = UserOrderType::where(['type_nid' => 'order_apply'])->first();
        $user_order = UserOrder::where(['user_id' => $uid, 'order_type' => $typeId->id])->first();
        return $user_order ? $user_order->toArray() : '';
    }
}