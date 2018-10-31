<?php

namespace App\Models\Factory\Admin\Order;

use App\Models\AbsModelFactory;
use App\Models\Orm\CertifyWand;

class CertifyWandFactory extends AbsModelFactory
{
    /**
     * @param $id
     *
     * @return mixed|static
     */
    public static function getById($id)
    {
        return CertifyWand::find($id);
    }
}
