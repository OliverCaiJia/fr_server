<?php

namespace App\Models\Chain\Report\Scopion;

use App\Constants\OrderConstant;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;

class CreateReportOrderLogAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '订单状态不合法，审核（拒绝）失败！', 'code' => 8210];

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * 第一步:入report log 和中间表
     *
     * @return array
     */
    public function handleRequest()
    {
        if ($this->createReportLog($this->params)) {
            $this->setSuccessor(new CheckAmountCountAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    private function createReportLog($params)
    {
        $data['user_report_type_id'] = $params['user_report_type_id'];
        $data['user_id'] = $params['user_id'];
        $data['order_id'] = $params['order_id'];
        $data['status'] = $params['status'];
        $data['create_at'] = $params['create_at'];
        $data['create_ip'] = $params['create_ip'];
        $data['update_at'] = $params['update_at'];
        $data['update_ip'] = $params['update_ip'];

        $userReportLog = UserOrderFactory::createUserReportLog($data);
        if (!$userReportLog) {
            $this->error['error'] = "用户您好，您还有未支付订单，请先进行支付！";
            return false;
        }
//        dd($userReportLog);//31
        $this->params['user_report_log_id'] = $userReportLog['id'];
        return true;
    }
}
