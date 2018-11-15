<?php

namespace App\Models\Factory\Api;

use App\Models\Orm\UserLoanLog;

class UserLoanLogFactory extends ApiFactory
{
    public static function createUserLoanLog($params)
    {

//        `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
//  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
//  `platform_id` int(11) unsigned NOT NULL COMMENT '平台接口id',
//  `loan_order_id` int(11) NOT NULL COMMENT '贷款申请订单id',
//  `expire_day` int(10) NOT NULL DEFAULT '0' COMMENT '失效时间',
//  `loan_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '申请金额',
//  `loan_peroid` int(8) NOT NULL DEFAULT '0' COMMENT '申请周期',
//  `request_data` json NOT NULL COMMENT '请求数据参数',
//  `response_data` json NOT NULL COMMENT '响应返回数据',
//  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
//  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',


        $userLoanLog = new UserLoanLog();
        $userLoanLog->user_id = $params['user_id'];
        $userLoanLog->platform_id = $params['platform_id'];//先写死 一键贷
        $userLoanLog->loan_order_id = $params['loan_order_id'];//上面环节的订单主键id
        $userLoanLog->expire_day = $params['expire_day'];//先写死7天
        $userLoanLog->loan_amount = $params['loan_amount'];//读配置
        $userLoanLog->loan_peroid = $params['loan_peroid'];//
        $userLoanLog->request_data = $params['request_data'];//请求参数json
        $userLoanLog->response_data = $params['response_data'];//一键贷返回的json
        $userLoanLog->create_at = $params['create_at'];
        $userLoanLog->update_at = $params['update_at'];
        return $userLoanLog->save();
    }
}
