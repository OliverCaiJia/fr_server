<?php

namespace App\Models\Chain\Report\Scopion;

use App\Helpers\Logger\SLogger;
use App\Helpers\Utils;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;

class CreateOrderReportAction extends AbstractHandler
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
        if ($this->createOrderReport($this->params)) {
            $this->setSuccessor(new UpdateUserInfoStatusAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    private function createOrderReport($params)
    {
        SLogger::getStream()->info(__CLASS__);

        $orderReportParam = [];
        $orderReportParam['order_id'] = $params['order_id'];
        $orderReportParam['report_id'] = $params['user_report_id'];
        $orderReportParam['create_at'] = date('Y-m-d H:i:s', time());
        $orderReportParam['create_ip'] =  Utils::ipAddress();
        $orderReport = UserOrderFactory::createOrderReport($orderReportParam);
        if (!$orderReport) {
            $this->error['error'] = "您好，报告关系异常！";
            return false;
        }
        return true;
    }
}
