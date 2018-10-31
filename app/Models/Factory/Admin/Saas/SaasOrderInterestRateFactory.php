<?php

namespace App\Models\Factory\Admin\Saas;

use App\Models\AbsModelFactory;
use App\Models\Orm\SaasOrderInterestRate;

class SaasOrderInterestRateFactory extends AbsModelFactory
{
    /**
     * @param $saasOrderId
     *
     * @return mixed|static
     */
    public static function getBySaasOrderId($saasOrderId)
    {
        return SaasOrderInterestRate::where('saas_order_id', $saasOrderId)->first();
    }

    /**
     * @param $params
     *
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    public static function create($params)
    {
        return SaasOrderInterestRate::create($params);
    }

    /**
     * @param $id
     * @param $params
     *
     * @return bool
     */
    public static function updateById($id, $params)
    {
        return SaasOrderInterestRate::where('id', $id)->update($params);
    }
}
