<?php

namespace App\Strategies;

use Carbon\Carbon;

class AdminAuthStrategy extends AppStrategy
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
        return true;
    }
}
