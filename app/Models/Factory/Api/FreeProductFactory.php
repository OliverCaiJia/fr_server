<?php

namespace App\Models\Factory\Api;

use App\Models\Orm\FreeProduct;

class FreeProductFactory extends ApiFactory
{
    /**
     * 根据免费产品唯一标识获取免费产品
     * @param $nid
     * @return array
     */
    public static function getFreeProductByNid($nid)
    {
        $freeProduct = FreeProduct::select()
            ->where('free_product_nid', '=', $nid)
            ->first();
        return $freeProduct ? $freeProduct->toArray() : [];
    }

    /**
     * 根据免费产品id获取免费产品
     * @param $id
     * @return array
     */
    public static function getFreeProductById($id)
    {
        $freeProduct = FreeProduct::select()
            ->where('id', '=', $id)
            ->first();
        return $freeProduct ? $freeProduct->toArray() : [];
    }
}
