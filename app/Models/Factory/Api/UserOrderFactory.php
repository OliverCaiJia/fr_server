<?php
/**
 * Created by PhpStorm.
 * User: zengqiang
 * Date: 17-10-27
 * Time: 上午9:57
 */

namespace App\Models\Factory;

use App\Constants\UserVipConstant;
use App\Models\Factory\Api\ApiFactory;
use App\Models\Orm\AccountPayment;
use App\Models\Orm\UserOrder;
use App\Models\Orm\UserOrderType;


class UserOrderFactory extends ApiFactory
{
    /**
     * 创建订单
     *
     * @param $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function createOrder($data)
    {
        return UserOrder::updateOrCreate($data);
    }

    /**
     * 获取订单类型ID
     *
     * @param string $nid
     * @return int
     */
    public static function getOrderType($nid = UserVipConstant::ORDER_TYPE)
    {
        $id = UserOrderType::where(['type_nid' => $nid])->value('id');

        return $id ? $id : 1;
    }

    /**
     * 根据订单编号获取订单
     * @param $id
     * @return mixed
     */
    public static function getOrderByOrderNo($order_no)
    {
        return UserOrder::select()->where('order_no', '=', $order_no)->first();
    }
}
