<?php

namespace App\Models\Factory\Api;

use App\Helpers\Logger\SLogger;
use App\Models\Factory\Api\ApiFactory;
use App\Strategies\UserOrderStrategy;
use App\Models\Orm\UserOrder;
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
        SLogger::getStream()->error('=====666=====');
        SLogger::getStream()->error($orderStatus);
        SLogger::getStream()->error('=====777=====');
        //不等于空修改状态
        if (!empty($orderStatus)) {
            $orderStatus->status = 1;
            $orderStatus->update_at = date('Y-m-d H:i:s');
            $orderStatus->save();
            $userInfo = UserInfo::where(['user_id' => $uid, 'service_status' => 3])->first();

            SLogger::getStream()->error('=====888=====');
            SLogger::getStream()->error($userInfo);
            SLogger::getStream()->error('=====999=====');
            if (!empty($userInfo)) {
                $userInfo->status = 4;
                $userInfo->update_at = date('Y-m-d H:i:s');
                if ($userInfo->save()) {
                    return $userInfo->toArray();
                }
            }

        }
    }
}