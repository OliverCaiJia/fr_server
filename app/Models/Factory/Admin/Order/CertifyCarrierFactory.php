<?php

namespace App\Models\Factory\Admin\Order;

use App\Models\AbsModelFactory;
use App\Models\Orm\CertifyCarrier;

class CertifyCarrierFactory extends AbsModelFactory
{
    /**
     * @param $id
     *
     * @return mixed|static
     */
    public static function getById($id)
    {
        return CertifyCarrier::find($id);
    }

    /**
     * @param $id
     * @param $params
     *
     * @return bool
     */
    public static function updateById($id, $params)
    {
        return CertifyCarrier::where('id', $id)->update($params);
    }

    /**
     * @param $params
     *
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    public static function create($params)
    {
        return CertifyCarrier::create($params);
    }
}
