<?php

namespace App\Models\Factory;

use App\Models\Factory\Api\ApiFactory;
use App\Models\Orm\Banner;

/**
 * Class BanksFactory
 * @package App\Models\Factory
 * banner工厂
 */
class BannerFactory extends ApiFactory
{
    /**
     * @param $banner_type_id
     * @return array
     * 根据类型id获取banner列表
     */
    public static function getBannerListByTypeId($banner_type_id)
    {
        $bannerList = Banner::select(['id','banner_name','position','img_address','img_href'])
            ->where(['banner_type_id',$banner_type_id])
            ->get();

        return $bannerList ? $bannerList->toArry() : [];
    }

    /**
     * @param $banner_type_id
     * @return array
     * 根据类型id获取指定类型banner
     */

    public static function getBannerByTypeId($banner_type_id)
    {
        $bannerList = Banner::select(['id','banner_name','position','img_address','img_href'])
            ->where(['banner_type_id',$banner_type_id])
            ->first();

        return $bannerList ? $bannerList->toArry() : [];
    }

    /**
     * @param $banner_type_nid
     * @return array
     *根据类型标识获取banner列表
     */

    public static function getBannerListByTypeNid($banner_type_nid)
    {
        $bannerList = Banner::select(['id','banner_name','position','img_address','img_href'])
            ->where(['banner_type_nid',$banner_type_nid])
            ->get();

        return $bannerList ? $bannerList->toArray() : [];
    }

    /**
     * @param $banner_type_nid
     * @return array
     * 根据类型标识获取指定banner
     */

    public static function getBannerByTypeNid($banner_type_nid)
    {
        $bannerList = Banner::select(['id','banner_name','position','img_address','img_href'])
            ->where(['banner_type_nid',$banner_type_nid])
            ->first();

        return $bannerList ? $bannerList->toArry() : [];
    }

}