<?php

namespace App\Models\Factory\Api;

use App\Models\Orm\UserOrderType;

class UserOrderTypeFactory extends ApiFactory
{
    /**
     * 获取使用中订单类型列表
     * @return array
     */
    public static function getOrderTypeLists()
    {
        $type = UserOrderType::where('status', 1)->get();
        return $type ? $type->toArray() : [];
    }

    /**
     * 获取使用中订单类型标识
     * @return array
     */
    public static function getOrderTypeNidLists()
    {
        $type = UserOrderType::where('status', 1)->pluck('name', 'id');
        return $type ? $type->toArray() : [];
    }
}
