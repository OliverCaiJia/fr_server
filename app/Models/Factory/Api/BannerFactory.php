<?php

namespace App\Models\Factory\Api;

use App\Models\Orm\Banner;
use App\Models\Orm\BannerType;

class BannerFactory extends ApiFactory
{
    /**
     * 获取轮播图类型
     * @param $typeNid
     * @return string
     */
    public static function fetchTypeId($typeNid)
    {
        $typeId = BannerType::select(['id'])
            ->where(['type_nid' => $typeNid, 'status' => 1])
            ->first();

        return $typeId ? $typeId->id : '';
    }

    public static function IsBanner($type)
    {
        $typeNid = self::fetchTypeId($type);
        $data = self::fetchBanners($typeNid);
        return $data;
    }

    /**
     * 获取轮播图信息
     * @param $typeNid
     * @param $status
     * @return array
     */
    public static function fetchBanners($typeNid)
    {
        //type_id 1 广告，status 1 存在
        $bannerList = Banner::where(['status' => 1, 'banner_type_id' => $typeNid])
            ->orderBy('position')
            ->limit(5)
            ->select('banner_name',
                'position',
                'img_address',
                'img_href')
            ->get()->toArray();
        return $bannerList ? $bannerList : [];
    }

    /**
     * 更新轮播图类型状态
     * @param $typeNid
     * @param $status
     * @return mixed
     */
    public static function updateBannerTypeStatus($typeNid, $status)
    {
        return BannerType::where(['type_nid' => $typeNid])->update(['status' => $status]);
    }
}
