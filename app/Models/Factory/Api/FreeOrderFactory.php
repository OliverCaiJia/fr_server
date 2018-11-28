<?php

namespace App\Models\Factory\Api;

use App\Models\Factory\Api\ApiFactory;
use App\Strategies\UserOrderStrategy;
use App\Models\Orm\UserOrder;
use App\Models\Orm\UserLoanTask;
use App\Helpers\Utils;

/**
 * Class FreeOrderFactory
 * @package App\Models\Factory\Api
 */
class FreeOrderFactory extends ApiFactory
{
    public static function Order($uid, $amount, $term)
    {
        $orderStatus = UserLoanTask::where(['user_id' => $uid])->first();
        //修改的时间
        $register = strtotime($orderStatus->update_at);
        //30天过期时间
        $endtime = 30 * 24 * 60 * 60;
        //当前时间
        $nowtime = time();
        if (($nowtime - $register) > $endtime) {
            $userOrder = new UserOrder();
            $userOrder->user_id = $uid;
            $userOrder->order_no = UserOrderStrategy::createOrderNo();
            $userOrder->order_type = 2;
            $userOrder->p_order_id = 0;
            $userOrder->order_expired = date('Y-m-d H:i:s', strtotime('+1 hour'));
            $userOrder->amount = $amount;
            $userOrder->term = $term;
            $userOrder->count = 1;
            $userOrder->status = 1;
            $userOrder->create_ip = Utils::ipAddress();
            $userOrder->create_at = date('Y-m-d H:i:s', time());
            $userOrder->update_ip = Utils::ipAddress();
            $userOrder->update_at = date('Y-m-d H:i:s', time());
            $data = $userOrder->save();
            if ($data == 1) {
                return $data = [];
            }
        } else {
            return $orderStatus ? $orderStatus->toArray() : [];
        }
    }

}