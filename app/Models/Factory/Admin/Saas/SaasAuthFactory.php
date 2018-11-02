<?php

namespace App\Models\Factory\Admin\Saas;

use App\Models\AbsModelFactory;
use App\Models\Orm\SaasAuth;

class SaasAuthFactory extends AbsModelFactory
{
    /**
     * 获取 saas 用户部分信息
     *
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public static function getSaasAuthById($id)
    {
        return SaasAuth::select('id', 'full_company_name', 'account_name')->findOrFail($id);
    }

    /**
     * 通过主键ID获取合作方用户全部信息
     * @param $saasId
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public static function getSaasInfoById($saasId)
    {
        return SaasAuth::whereKey($saasId)->first();
    }
}
