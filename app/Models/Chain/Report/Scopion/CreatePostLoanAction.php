<?php

namespace App\Models\Chain\Report\Scopion;

use App\Constants\OrderConstant;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;

class CreatePostLoanAction extends AbstractHandler
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
        if ($this->createPostloan($this->params)) {
            $this->setSuccessor(new CreateBlackListAction($this->params));
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

    private function createPostloan($params)
    {
//        CREATE TABLE `sgd_user_postloan` (
//    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
//  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
//  `user_report_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关联的jt_user_reports表的id',
//  `transid` varchar(128) NOT NULL DEFAULT '' COMMENT '传输id',
//  `due_days_non_cdq_12_mon` int(8) NOT NULL COMMENT '近12个月最近一次非超短期现金贷逾期距今天数(',
//  `pay_cnt_12_mon` int(8) NOT NULL DEFAULT '0' COMMENT '近12个月累计还款笔数',
//  `data` json NOT NULL COMMENT '贷后行为',
//  `fee` varchar(255) NOT NULL DEFAULT '',
//  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
//  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
//  PRIMARY KEY (`id`),
//  KEY `FK_USER_POSTLOAN_USER_ID` (`user_id`),
//  CONSTRAINT `FK_USER_POSTLOAN_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `sgd_user_auth` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
//) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户贷后数据表'
        $data['user_id'] = $params['user_id'];
        $data['user_report_id'] = $params['user_report_id'];
        $data['transid'] = $params['transid'];
        $data['due_days_non_cdq_12_mon'] = $params['due_days_non_cdq_12_mon'];
        $data['pay_cnt_12_mon'] = $params['pay_cnt_12_mon'];
        $data['data'] = $params['data'];
        $data['fee'] = $params['fee'];
        $data['create_at'] = $params['create_at'];
        $data['update_at'] = $params['update_at'];

        $userReportLog = UserOrderFactory::createPostloan($data);

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
