<?php

namespace App\Models\Chain\Report\Scopion;

use App\Constants\OrderConstant;
use App\Helpers\Logger\SLogger;
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
     *
     * @return array
     */
    public function handleRequest()
    {
        if ($this->createReport($this->params)) {
            $this->setSuccessor(new CreateOrderReportAction($this->params));//
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    private function createReport($params)
    {
        SLogger::getStream()->info(__CLASS__);
        $report['user_id'] = $params['user_id'];
        $report['report_code'] = 'R-' . UserOrderStrategy::createOrderNo();
        $report['report_data'] = json_encode($params['report_data']);
        $report['create_at'] = date('Y-m-d H:i:s');
        $report['update_at'] = date('Y-m-d H:i:s');

        $userReport = UserOrderFactory::createReport($report);
        $this->params['user_report_id'] = $userReport['id'];

        if (!$report) {
            $this->error['error'] = "您好，报告录入异常！";
            return false;
        }
        return true;

    }
}
