<?php

namespace App\Models\Chain\Report\Scopion;

use App\Constants\OrderConstant;
use App\Helpers\Logger\SLogger;
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
    }

    private function createMultiinfo($params)
    {
        SLogger::getStream()->error(__CLASS__);

        $data['user_id'] = $params['user_id'];
        $data['user_report_id'] = $params['user_report_id'];
        $data['register_org_count'] = $params['multi_info']['data']['auth_queried_detail']['register_info']['org_count'];

        $data['loan_cnt'] = $params['multi_info']['data']['auth_queried_detail']['loan_info']['loan_cnt'];
        $data['loan_org_cnt'] = $params['multi_info']['data']['auth_queried_detail']['loan_info']['loan_org_cnt'];
        $data['transid'] = $params['multi_info']['data']['trans_id'];
        $data['data'] = json_encode($params['multi_info']['data']);
        $data['fee'] = $params['multi_info']['fee'];
        $data['create_at'] = date('Y-m-d H:i:s', time());
        $data['update_at'] = date('Y-m-d H:i:s', time());

        $userMultiinfo = UserOrderFactory::createMultiinfo($data);

        if (!$userMultiinfo) {
            $this->error['error'] = "您好，报告记录关系异常！";
            return false;
        }
        return true;
    }
}
