<?php

namespace App\Models\Factory\Api;

use App\Models\Orm\Product;


/**
 * Class ProductFactory
 * @package App\Models\Factory\Api
 * 产品
 */
class ProductFactory extends ApiFactory
{
    /**
     * 获取产品列表
     */
    public static function getProductList()
    {
        $productArr = Product::where(['online_status' => 0,'is_delete' => 0])->get();

        return $productArr ? $productArr->toArray() : [];
    }

    /**
     * 根据产品productId获取产品
     * @param $productId
     */
    public static function getProductById($productId)
    {
        $productArr = Product::where(['online_status' => 0,'is_delete' => 0,'product_id' => $productId])->first();

        return $productArr ? $productArr->toArray() : [];
    }

    /**
     * @param $productId
     * 根据产品productId获取产品名称
     */
    public static function getProductNameById($productId)
    {
        $productArr = Product::where(['online_status' => 0,'is_delete' => 0,'product_id' => $productId])->value('platform_product_name');

        return $productArr ?? '';
    }

    /**
     * @param $platform_id
     * 根据平台获取产品
     */
    public static function getProductsByPaltform($platform_id)
    {
        $productArr = Product::where(['online_status' => 0,'is_delete' => 0,'platform_id' => $platform_id])->get();

        return $productArr ? $productArr->toArray() : [];
    }

    /**
     * @param $platform_id
     * 获取推荐产品列表
     */
    public static function getLoadProducts()
    {
        $productArr = Product::select('platform_product_name','product_logo','product_introduct','loan_min','loan_max')
                ->where('online_status', 0)
                ->get();

        return $productArr ? $productArr->toArray() : [];
    }
}
