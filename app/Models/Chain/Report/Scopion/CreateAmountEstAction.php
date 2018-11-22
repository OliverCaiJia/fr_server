<?php

namespace App\Models\Chain\Report\Scopion;

use App\Constants\OrderConstant;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;

class CreateAmountEstAction extends AbstractHandler
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
        if ($this->createAmountEst($this->params)) {
            $this->setSuccessor(new CreatePostLoanAction($this->params));
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

    private function createAmountEst($params)
    {
//        CREATE TABLE `sgd_user_amount_est` (
//    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
//  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
//  `user_report_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关联的user_reports表的id',
//  `zm_score` int(8) NOT NULL DEFAULT '0' COMMENT '芝麻分',
//  `huabai_limit` int(8) NOT NULL DEFAULT '0' COMMENT '花呗额度',
//  `credit_amt` int(8) NOT NULL DEFAULT '0' COMMENT '借呗额度',
//  `data` json NOT NULL COMMENT '返回数据',
//  `fee` varchar(255) NOT NULL DEFAULT '' COMMENT '是否收费',
//  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
//  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
//  PRIMARY KEY (`id`),
//  KEY `FK_USER_MULTIINFO_USER_ID` (`user_id`),
//  CONSTRAINT `sgd_user_amount_est_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `sgd_user_auth` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
//) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户电商额度数据表'
        $data['user_id'] = $params['user_id'];//6
        $data['user_report_id'] = $params['user_report_id'];//1
        $data['zm_score'] = $params['zm_score'];//1
        $data['huabai_limit'] = $params['huabai_limit'];//1
        $data['credit_amt'] = $params['credit_amt'];//1
        $data['data'] = $params['data'];//'{"people":[{"firstName":"Brett","lastName":"McLaughlin","email":"aaaa"},{"firstName":"Jason","lastName":"Hunter","email":"bbbb"},{"firstName":"Elliotte","lastName":"Harold","email":"cccc"}]}'
        $data['fee'] = $params['fee'];//'Y'
        $data['create_at'] = date('Y-m-d H:i:s', time());
        $data['update_at'] = date('Y-m-d H:i:s', time());

        $userReportLog = UserOrderFactory::createAmountEst($data);

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
