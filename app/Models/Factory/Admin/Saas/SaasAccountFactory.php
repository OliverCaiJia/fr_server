<?php

namespace App\Models\Factory\Admin\Saas;

use App\Models\AbsModelFactory;
use App\Models\Orm\SaasAccount;

class SaasAccountFactory extends AbsModelFactory
{
    /**
     * 获取余额通过ID
     *
     * @param $id
     *
     * @return mixed|string
     */
    public static function getBalanceById($id)
    {
        $account = SaasAccount::select('balance')->where('user_id', $id)->first();

        return $account ? $account->balance : '未知';
    }
}
