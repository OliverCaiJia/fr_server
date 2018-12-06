<?php

namespace App\Models\Factory\Api;

use App\Models\Orm\UserFreeProduct;

class UserFreeProductFactory extends ApiFactory
{
    /**
     * 创建免费产品
     * @param $params
     * @return bool
     */
    public static function createUserFreeProduct($params)
    {
        $userFreeProduct = new UserFreeProduct();
        $userFreeProduct->user_id = $params['user_id'];
        $userFreeProduct->order_id = $params['order_id'];
        $userFreeProduct->free_product_id = $params['free_product_id'];
        $userFreeProduct->create_at = $params['create_at'];
        $userFreeProduct->update_at = $params['update_at'];

        if ($userFreeProduct->save()) {
            return $userFreeProduct->toArray();
        }
        return false;
    }

    /**
     * 根据用户id和订单id获取用户免费产品
     * @param $userId
     * @param $orderId
     * @return array
     */
    public static function getUserFreeProductByUserIdAndOrderId($userId, $orderId)
    {
        $userFreeProduct = UserFreeProduct::select()
            ->where('user_id', '=', $userId)
            ->where('order_id', '=', $orderId)
            ->first();
        return $userFreeProduct ? $userFreeProduct->toArray() : [];
    }
}
