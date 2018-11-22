<?php

namespace App\Models\Chain\Report\Scopion;

use App\Constants\OrderConstant;
use App\Helpers\Utils;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;
use App\Services\Core\Validator\Scorpion\Mozhang\MozhangService;
use App\Strategies\UserOrderStrategy;

class CreateReportAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '订单状态不合法，审核（拒绝）失败！', 'code' => 8210];

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     *
     *s
     * @return array
     */
    public function handleRequest()
    {
        if ($this->createReport($this->params)) {
            $this->setSuccessor(new CreateAntifraudAction($this->params));
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

    private function createReport($params)
    {

//        CREATE TABLE `sgd_user_report` (
//    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
//  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
//  `report_code` varchar(128) NOT NULL DEFAULT '' COMMENT '报告编号',
//  `report_data` json NOT NULL COMMENT '报告数据',
//  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
//  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
//  PRIMARY KEY (`id`),
//  UNIQUE KEY `FK_USER_REPORT_USER_ID` (`user_id`) USING BTREE,
//  CONSTRAINT `FK_USER_REPORT_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `sgd_user_auth` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
//) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户报告信息表'
        $report['user_id'] = $params['user_id'];//6
        //todo::
        $report['report_code'] = 'R' . UserOrderStrategy::createOrderNo();
        $report['report_data'] = '{"people":[{"firstName":"Brett","lastName":"McLaughlin","email":"aaaa"},{"firstName":"Jason","lastName":"Hunter","email":"bbbb"},{"firstName":"Elliotte","lastName":"Harold","email":"cccc"}]}';//json_encode($params['report_data'])
        $report['create_at'] = date('Y-m-d H:i:s');
        $report['update_at'] = date('Y-m-d H:i:s');
        $userReport = UserOrderFactory::createReport($report);
        $this->params['user_report_id'] = $userReport['id'];



//        $userId = $params['user_id'];
//        $orderType = $params['order_type'];
//        $userOrder = UserOrderFactory::getUserOrderByUserIdAndOrderType($userId, $orderType);
//
        if (!$report) {
            $this->error['error'] = "您好，报告录入异常！";
            return false;
        }
        return true;

    }
}
