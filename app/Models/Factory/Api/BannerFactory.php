<?php

namespace App\Models\Factory\Api;

use App\Models\Orm\Banner;
use App\Models\Orm\BannerType;
use App\Models\Orm\BannerLinkType;

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
                'link_type',
                'position',
                'img_address',
                'img_href')
            ->get()->toArray();

        $bannerLists = self::getLinkTypeName($bannerList);

        return $bannerLists ? $bannerLists : [];
    }

    /**
     * 更新轮播图类型状态
     * @param $typeNid
     * @param $status
     * @return mixed
     */
    public static function getLinkTypeName($bannerList = [])
    {
        foreach ($bannerList as &$val) {

            $val['link_type'] = self::getLinkName($val['link_type']);
        }
        return $bannerList ? $bannerList : '';
//        return BannerType::where(['type_nid' => $typeNid])->update(['status' => $status]);
    }

    public static function getLinkName($id)
    {
        $LinkType = BannerLinkType::where(['id' => $id])->first();
        return $LinkType ? $LinkType->link_type_nid : '';
    }
}
