<?php

namespace App\Models\Factory;

use App\Models\Factory\Api\ApiFactory;
use App\Models\Orm\Banner;

/**
 * Class BanksFactory
 * @package App\Models\Factory
 * 获取banner
 */
class BannerFactory extends ApiFactory
{
    /**
     * @param $banner_type_id
     * @return array
     * 获取指定类型banner
     */
    public static function bannerList($banner_type_id)
    {
        $bannerList = Banner::select(['banner_name','position','img_address','img_href'])
            ->where(['banner_type_id',$banner_type_id])
            ->get()
            ->toArray();

        return $bannerList;
    }


}