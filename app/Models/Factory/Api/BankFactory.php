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

    /**
     * 根据银行id获取单个银行信息
     * @param $id
     * @return array
     *
     */
    public static function fetchBankinfoById($bank_code)
    {
        $bank = Bank::where(['bank_code' => $bank_code, 'status' => 1])
            ->first();

        return $bank ? $bank->toArray() : [];
    }
}
