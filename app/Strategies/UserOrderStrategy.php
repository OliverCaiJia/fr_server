<?php

namespace App\Strategies;

use App\Helpers\Utils;
use App\Models\Chain\Order\DoAssignHandler;
use App\Models\Factory\Api\UserOrderFactory;
use Illuminate\Http\Request;

class UserOrderStrategy extends AppStrategy
{
    /**
     * 创建订单号
     *
     * @param string $type
     *
     * @return string
     */
    public static function createOrderNo($type = 'SGD')
    {
        $NO = date('Y') . date('m') . date('d') . date('H') . date('i') . date('s') . '-' . Utils::randomNumber();

        return $type . '-' . $NO;
    }

    /**
     * 获取渠道名称展示文案
     *
     * @param $order
     *
     * @return mixed
     */
    public static function getChannelText($order)
    {
        if (is_array($order)) {
            $channel = $order['saas_channel_detail'];
            return $channel['name'];
        }

        $channel = $order->saas_channel_detail;

        return $channel['name'];
    }

    /**
     * 获取状态展示文案
     *
     * @param $status
     *
     * @return string
     */
    public static function getStatusText($status)
    {
        switch ($status) {
            case 1:
                $status = '待初审订单';
                break;
            case 2:
                $status = '待放款订单';
                break;
            case 3:
                $status = '审核不通过';
                break;
            case 4:
                $status = '已拒绝放款';
                break;
            case 5:
                $status = '待还款订单';
                break;
            case 6:
                $status = '逾期未还订单';
                break;
            case 7:
                $status = '已还款订单';
                break;
        }

        return $status;
    }

    public static function getUserIdByXToken(Request $request)
    {
        $token = $request->input('token') ?: $request->header('X-Token');
        $userOrder = UserOrderFactory::getUserAuthByAccessToken($token);
        return $userOrder['id'];
    }
}
