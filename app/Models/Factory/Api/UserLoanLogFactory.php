<?php

namespace App\Models\Factory\Api;

use App\Models\Orm\UserLoanLog;

class UserLoanLogFactory extends ApiFactory
{
    public static function createUserLoanLog($params)
    {
        $userLoanLog = new UserLoanLog();
        $userLoanLog->user_id = $params['user_id'];
        $userLoanLog->platform_id = $params['platform_id'];//先写死 一键贷
        $userLoanLog->loan_order_no = $params['order_no'];//上面环节的订单编号
        $userLoanLog->expire_day = $params['order_expired'];//先写死7天
        $userLoanLog->loan_amount = $params['money'];//申请金额
        $userLoanLog->loan_peroid = $params['term'];//申请周期
        $userLoanLog->request_data = $params['request_data'];//请求参数json
        $userLoanLog->response_data = $params['response_data'];//一键贷返回的json
        $userLoanLog->create_at = $params['create_at'];
        if($userLoanLog->save()){
            return $userLoanLog->toArray();
        }
        return false;
    }
}
