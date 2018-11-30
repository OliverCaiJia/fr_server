<?php

namespace App\Models\Chain\Report\Scopion;

use App\Constants\OrderConstant;
use App\Helpers\Logger\SLogger;
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
    }

    private function createApply($params)
    {
        SLogger::getStream()->error(__CLASS__);

        $data['user_id'] = $params['user_id'];
        $data['user_report_id'] = $params['user_report_id'];
        $data['transid'] = $params['application']['data']['trans_id'];
        $data['data'] = json_encode($params['application']['data']);
        $data['fee'] = $params['application']['fee'];
        $data['create_at'] = date('Y-m-d H:i:s', time());
        $data['update_at'] = date('Y-m-d H:i:s', time());

        $userApply = UserOrderFactory::createApply($data);

        if (!$userApply) {
            $this->error['error'] = "您好，报告记录关系异常！";
            return false;
        }
        return true;
    }
}
