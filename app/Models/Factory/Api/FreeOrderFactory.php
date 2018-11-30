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
    public static function Order($uid)
    {
        $orderStatus = UserLoanTask::where(['user_id' => $uid, 'status' => 0])->first();
        //如果等于
        if (!empty($orderStatus)) {
            $orderStatus->status = 1;
            $orderStatus->update_at = date('Y-m-d H:i:s');
            if ($orderStatus->save()) {
                return $orderStatus->toArray();
            }
        }
    }
}