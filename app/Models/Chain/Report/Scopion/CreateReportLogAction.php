<?php

namespace App\Models\Chain\Report\Scopion;

use App\Constants\OrderConstant;
use App\Helpers\Utils;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;
use App\Services\Core\Validator\Scorpion\Mozhang\MozhangService;

class CreateReportLogAction extends AbstractHandler
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
        if ($this->createReportLog($this->params)) {
            $this->setSuccessor(new CreateReportAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }

//        $result = UserOrderFactory::createOrderReport($this->params);
//        if ($result) {
//            return true;
//        }user_report_type_id
//        return $this->error;
    }

    private function createReportLog($params)
    {
        //        CREATE TABLE `sgd_user_report_log` (
//    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
//  `user_report_type_id` int(11) unsigned NOT NULL COMMENT '报告类型id',
//  `user_id` int(11) NOT NULL COMMENT '用户id',
//  `order_id` int(11) NOT NULL COMMENT '订单id',
//  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '报告状态 0待支付 1支付完成 2报告完成',
//  `data` json NOT NULL COMMENT '报告返回数据',
//  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
//  `create_ip` varchar(16) NOT NULL DEFAULT '' COMMENT '创建IP',
//  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
//  `update_ip` varchar(16) NOT NULL DEFAULT '' COMMENT '更新IP',
//  PRIMARY KEY (`id`)
//) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COMMENT='用户报告日志表（单次请求）'
        SLogger::getStream()->error(__CLASS__);

        $reportLog['user_report_type_id'] = $params['user_report_type_id'];//=1
        $reportLog['user_id'] = $params['user_id'];//=6
        $reportLog['order_id'] = $params['order_id'];//=91
        $reportLog['status'] = 1;
//        $reportLog['data'] = json_encode($params['report_data']);//'{"people":[{"firstName":"Brett","lastName":"McLaughlin","email":"aaaa"},{"firstName":"Jason","lastName":"Hunter","email":"bbbb"},{"firstName":"Elliotte","lastName":"Harold","email":"cccc"}]}'
        $reportLog['create_at'] = date('Y-m-d H:i:s', time());
        $reportLog['create_ip'] = Utils::ipAddress();
        $reportLog['update_at'] = date('Y-m-d H:i:s', time());
        $reportLog['update_ip'] = Utils::ipAddress();

        $reportLog['data'] = json_encode($params['anti_fraud']);
        $reportLog = UserOrderFactory::createReportLog($reportLog);

        $reportLog['data'] = json_encode($params['application']);
        $reportLog = UserOrderFactory::createReportLog($reportLog);

        $reportLog['data'] = json_encode($params['credit_qualification']);
        $reportLog = UserOrderFactory::createReportLog($reportLog);

        $reportLog['data'] = json_encode($params['post_load']);
        $reportLog = UserOrderFactory::createReportLog($reportLog);

        $reportLog['data'] = json_encode($params['black_gray']);
        $reportLog = UserOrderFactory::createReportLog($reportLog);

        $reportLog['data'] = json_encode($params['multi_info']);
        $reportLog = UserOrderFactory::createReportLog($reportLog);

//        $userId = $params['user_id'];
//        $orderType = $params['order_type'];
//        $userOrder = UserOrderFactory::getUserOrderByUserIdAndOrderType($userId, $orderType);
//
        if (!$reportLog) {
            $this->error['error'] = "您好，用户报告报告录入异常！";
            return false;
        }
        return true;
    }
}
