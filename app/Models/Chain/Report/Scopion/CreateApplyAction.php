<?php

namespace App\Models\Chain\Report\Scopion;

use App\Constants\OrderConstant;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;

class CreateApplyAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '订单状态不合法，审核（拒绝）失败！', 'code' => 8210];

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     *
     *
     * @return array
     */
    public function handleRequest()
    {
        if ($this->createApply($this->params)) {
            $this->setSuccessor(new CreateAmountEstAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }

//        $result = UserOrderFactory::createOrderReport($this->params);
//        if ($result) {
//            return true;
//        }
//        return $this->error;
    }

    private function createApply($params)
    {
        //        CREATE TABLE `sgd_user_apply` (
//    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
//  `user_id` int(11) unsigned DEFAULT NULL COMMENT '用户id',
//  `user_report_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关联的jt_user_reports表的id',
//  `transid` varchar(128) NOT NULL DEFAULT '' COMMENT '传输id',
//  `due_days_non_cdq_12_mon` int(8) NOT NULL DEFAULT '0' COMMENT '近12个月最近一次非超短期现金贷逾期距今天数(',
//  `pay_cnt_12_mon` int(8) NOT NULL DEFAULT '0' COMMENT '近12个月累计还款笔数',
//  `loan_behavior_analysis` json NOT NULL COMMENT '贷后行为',
//  `data` json NOT NULL,
//  `fee` varchar(255) NOT NULL DEFAULT '' COMMENT '收费',
//  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
//  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
//  PRIMARY KEY (`id`),
//  UNIQUE KEY `FK_USER_APPLYIN_USER_ID` (`user_id`) USING BTREE,
//  CONSTRAINT `FK_USER_APPLYIN_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `sgd_user_auth` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
//) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户注入信息表'
        $data['user_id'] = $params['user_id'];//6
        $data['user_report_id'] = $params['user_report_id'];//1
        $data['transid'] = $params['transid'];//1
        $data['due_days_non_cdq_12_mon'] = $params['due_days_non_cdq_12_mon'];//1
        $data['pay_cnt_12_mon'] = $params['pay_cnt_12_mon'];//1
        $data['loan_behavior_analysis'] = $params['loan_behavior_analysis'];//'{"people":[{"firstName":"Brett","lastName":"McLaughlin","email":"aaaa"},{"firstName":"Jason","lastName":"Hunter","email":"bbbb"},{"firstName":"Elliotte","lastName":"Harold","email":"cccc"}]}'
        $data['data'] = $params['data'];//'{"people":[{"firstName":"Brett","lastName":"McLaughlin","email":"aaaa"},{"firstName":"Jason","lastName":"Hunter","email":"bbbb"},{"firstName":"Elliotte","lastName":"Harold","email":"cccc"}]}'
        $data['fee'] = $params['fee'];//'Y'
        $data['create_at'] = date('Y-m-d H:i:s', time());
        $data['update_at'] = date('Y-m-d H:i:s', time());

        $userReportLog = UserOrderFactory::createApply($data);

//        $userId = $params['user_id'];
//        $orderType = $params['order_type'];
//        $userOrder = UserOrderFactory::getUserOrderByUserIdAndOrderType($userId, $orderType);
//
        if (!$userReportLog) {
            $this->error['error'] = "您好，报告记录关系异常！";
            return false;
        }
        return true;
    }
}
