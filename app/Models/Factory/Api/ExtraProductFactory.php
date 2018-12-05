<?php

namespace App\Models\Factory\Api;

use App\Models\Orm\ExtraProduct;

class ExtraProductFactory extends ApiFactory
{
    /**
     * 获取产品信息
     * @param $id
     * @return mixed
     */
    public static function getExtraProduct()
    {
        $platform = ExtraProduct::get();
        return $platform ? $platform->toArray() : [];
    }
}
