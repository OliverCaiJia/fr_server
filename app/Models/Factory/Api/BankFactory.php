<?php

namespace App\Models\Factory\Api;

use App\Models\Orm\Bank;

class BankFactory extends ApiFactory
{
    /**
     * 获取支持列表银行
     * @return array
     */
    public static function getBankLists()
    {
        $banks = Bank::select('bank_code','bank_name','bank_logo','single_limit','day_limit')->get();
        return $banks ? $banks->toArray() : [];
    }
}
