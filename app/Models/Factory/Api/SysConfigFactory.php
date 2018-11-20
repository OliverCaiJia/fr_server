<?php

namespace App\Models\Factory\Api;

use App\Models\Orm\SysConfig;

/**
 * Class BanksFactory
 * @package App\Models\Factory
 * 系统配置表工厂
 */
class SysConfigFactory extends ApiFactory
{
    /**
     * @param $fee_type_id
     * @return array
     * 根据类型id获取费用信息列表
     */
    public static function getSysByKey($home_default_keys)
    {
        $sysRes = SysConfig::where('status','=',1)->whereIn('key',$home_default_keys)->get();

        return $sysRes ? $sysRes->toArray() : [];
    }
}