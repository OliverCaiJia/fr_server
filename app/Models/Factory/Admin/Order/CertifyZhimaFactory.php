<?php

namespace App\Models\Factory\Admin\Order;

use App\Models\AbsModelFactory;
use App\Models\Orm\CertifyZhima;

class CertifyZhimaFactory extends AbsModelFactory
{
    /**
     * @param $id
     *
     * @return mixed|static
     */
    public static function getById($id)
    {
        return CertifyZhima::find($id);
    }

    /**
     * @param $id
     * @param $params
     *
     * @return bool
     */
    public static function updateById($id, $params)
    {
        return CertifyZhima::where('id', $id)->update($params);
    }

    /**
     * @param $params
     *
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    public static function create($params)
    {
        return CertifyZhima::create($params);
    }
}
