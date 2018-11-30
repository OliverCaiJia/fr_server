<?php

namespace App\Models\Chain\Report\Scopion;

use App\Constants\OrderConstant;
use App\Helpers\Logger\SLogger;
use App\Helpers\Utils;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;
use App\Services\Core\Validator\Scorpion\Mozhang\MozhangService;
use App\Strategies\UserOrderStrategy;

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
            $this->setSuccessor(new CreateAntifraudAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    private function createOrderReport($params)
    {
        SLogger::getStream()->error(__CLASS__);

        $orderReportParam = [];
        $orderReportParam['order_id'] = $params['order_id'];
        $orderReportParam['report_id'] = $params['user_report_id'];
        $orderReport = UserOrderFactory::createOrderReport($orderReportParam);
        if (!$orderReport) {
            $this->error['error'] = "您好，报告关系异常！";
            return false;
        }
        return true;
    }
}
