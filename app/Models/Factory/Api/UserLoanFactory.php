<?php

namespace App\Models\Factory\Api;

use App\Models\Orm\UserLoan;

class UserLoanFactory extends ApiFactory
{
    public static function createUserLoan($params)
    {
        $loan = new UserLoan();
        $loan->user_id = $params['user_id'];
        $loan->platform_id = $params['platform_id'];
        $loan->loan_order_no = $params['order_no'];
        $loan->expire_day = $params['order_expired'];
        $loan->loan_amount = $params['money'];
        $loan->loan_peroid = $params['term'];
        $loan->status = $params['res_status'];
        $loan->create_at = date('Y-m-d H:i:s');
        $loan->update_at = date('Y-m-d H:i:s');
        if($loan->save()){
            return $loan->toArray();
        }
        return false;
    }
}
