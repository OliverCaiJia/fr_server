<?php

namespace App\Strategies;

use App\Models\Factory\Admin\Saas\SaasAuthFactory;
use Carbon\Carbon;

class SaasAuthStrategy extends AppStrategy
{
    /**
     * 是否为一个可用的账户
     *
     * @param $saasId
     *
     * @return bool
     */
    public static function isAvailableAccount($saasId)
    {
        $saas = SaasAuthFactory::getSaasInfoById($saasId);

        return $saas->is_deleted == 0 && $saas->is_locked == 0 && $saas->valid_deadline > Carbon::now();
    }
}
