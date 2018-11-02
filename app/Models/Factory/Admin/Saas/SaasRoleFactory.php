<?php

namespace App\Models\Factory\Admin\Saas;

use App\Models\AbsModelFactory;
use App\Models\Orm\SaasRole;

class SaasRoleFactory extends AbsModelFactory
{
    /**
     * 通过角色名和合作方 id 获取角色 id
     *
     * @param $name
     * @param $saasAuthId
     *
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public static function getIdByNameAndSaasAuthId($name, $saasAuthId)
    {
        return SaasRole::where('name', $name)->where('saas_auth_id', $saasAuthId)->select('id')->first();
    }

    /**
     * 获取角色信息通过合作方 id
     *
     * @param $saasAuthId
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getBySaasAuthId($saasAuthId)
    {
        return SaasRole::where('saas_auth_id', $saasAuthId)->pluck('name', 'id');
    }
}
