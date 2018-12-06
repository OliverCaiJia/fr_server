<?php

namespace App\Models\Factory\Api;

use App\Models\Orm\UserLoanLog;
use App\Models\Orm\UserBorrowLog;

class UserBorrowLogFactory extends ApiFactory
{

    /**创建用户首页行为
     * @param $uid
     * @param $amount
     * @return array
     */
    public static function createUserBorrowLog($uid, $amount)
    {
        $userBorrow = new UserBorrowLog();
        $userBorrow->user_id = $uid;
        $userBorrow->loan_amount = $amount['amount'];
        $userBorrow->loan_peroid = $amount['term'];
        $userBorrow->create_at = date('Y-m-d H:i:s');
        $userBorrow->update_at = date('Y-m-d H:i:s');
        if ($userBorrow->save()) {
            return $userBorrow->toArray();
        }
    }

    /**
     * 根据用户id获取log信息（单条）
     * @param $userId
     * @return array
     */
    public static function getBorrowLogDesc($userId)
    {
        $borrowLog = UserBorrowLog::where('user_id', '=', $userId)
            ->orderBy('create_at', 'desc')
            ->first();
        return $borrowLog ? $borrowLog->toArray() : [];
    }
}
