<?php

namespace App\Models\Factory\Admin\Order;

use App\Models\AbsModelFactory;
use App\Models\Orm\UserOrderType;

class OrderFactory extends AbsModelFactory
{
    /**
     * 通过用户主键ID获取用户名
     *
     * @param $id
     *
     * @return mixed|string
     */
    public static function getOrderTypeById($id)
    {
        $order = UserOrderType::where('id', $id)->value('name');

        return $order ?? '';
    }
}
