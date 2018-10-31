<?php

namespace App\Strategies;

use App\Helpers\Utils;
use App\Models\Chain\Order\DoAssignHandler;

class UserOrderStrategy extends AppStrategy
{
    /**
     * 创建订单号
     *
     * @param string $type
     *
     * @return string
     */
    public static function createOrderId($type = 'SD')
    {
        $nid = date('Y') . date('m') . date('d') . date('H') . date('i') . date('s') . '-' . Utils::randomNumber();

        return $type . '-' . $nid;
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
        if ($status == 1) {
            return '待处理';
        } elseif ($status == 2) {
            return '已通过';
        } elseif ($status == 3) {
            return '已拒绝';
        }
    }
}
