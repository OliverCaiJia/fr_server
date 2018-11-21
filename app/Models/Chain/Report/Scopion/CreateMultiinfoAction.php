<?php

namespace App\Models\Chain\Report\Scopion;

use App\Constants\OrderConstant;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;

class CreateMultiinfoAction extends AbstractHandler
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
        if ($this->createMultiinfo($this->params)) {
            $this->setSuccessor(new CreatePersonalAction($this->params));
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

    private function createMultiinfo($params)
    {
//        CREATE TABLE `sgd_user_multiinfo` (
//    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
//  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
//  `user_report_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关联的user_reports表的id',
//  `register_org_count` int(8) NOT NULL DEFAULT '0' COMMENT '注册机构数量',
//  `loan_cnt` int(8) NOT NULL DEFAULT '0' COMMENT '借贷次数',
//  `loan_org_cnt` int(8) NOT NULL DEFAULT '0' COMMENT '借贷机构数',
//  `transid` varchar(128) NOT NULL DEFAULT '' COMMENT '传输id',
//  `data` json NOT NULL,
//  `fee` varchar(255) NOT NULL DEFAULT '',
//  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
//  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
//  PRIMARY KEY (`id`),
//  KEY `FK_USER_MULTIINFO_USER_ID` (`user_id`),
//  CONSTRAINT `FK_USER_MULTIINFO_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `sgd_user_auth` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
//) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户多头数据表'
        $data['user_id'] = $params['user_id'];//
        $data['user_report_id'] = $params['user_report_id'];//
        $data['register_org_count'] = $params['register_org_count'];//
        $data['loan_cnt'] = $params['loan_cnt'];//
        $data['loan_org_cnt'] = $params['loan_org_cnt'];//
        $data['transid'] = $params['transid'];//
        $data['data'] = $params['data'];//'{"people":[{"firstName":"Brett","lastName":"McLaughlin","email":"aaaa"},{"firstName":"Jason","lastName":"Hunter","email":"bbbb"},{"firstName":"Elliotte","lastName":"Harold","email":"cccc"}]}'
        $data['fee'] = $params['fee'];//'Y'
        $data['create_at'] = date('Y-m-d H:i:s', time());
        $data['update_at'] = date('Y-m-d H:i:s', time());

        $userReportLog = UserOrderFactory::createMultiinfo($data);

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
