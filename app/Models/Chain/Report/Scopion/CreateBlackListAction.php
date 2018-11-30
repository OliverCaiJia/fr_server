<?php

namespace App\Models\Chain\Report\Scopion;

use App\Constants\OrderConstant;
use App\Helpers\Logger\SLogger;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;

class CreateBlackListAction extends AbstractHandler
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
        if ($this->createBlackList($this->params)) {
            $this->setSuccessor(new CreateMultiinfoAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    private function createBlackList($params)
    {
        SLogger::getStream()->error(__CLASS__);

        $data['user_id'] = $params['user_id'];
        $data['user_report_id'] = $params['user_report_id'];
        $data['transid'] = $params['black_gray']['data']['trans_id'];
        $data['mobile_name_in_blacklist'] = (int)$params['black_gray']['data']['black_info_detail']['mobile_name_in_blacklist'];
        $data['idcard_name_in_blacklist'] = (int)$params['black_gray']['data']['black_info_detail']['idcard_name_in_blacklist'];
        $data['black_info_detail'] = json_encode($params['black_gray']['data']['black_info_detail']);
        $data['gray_info_detail'] = json_encode($params['black_gray']['data']['gray_info_detail']);
        $data['data'] = json_encode($params['black_gray']['data']);
        $data['fee'] = $params['black_gray']['fee'];
        $data['create_at'] = date('Y-m-d H:i:s', time());
        $data['update_at'] = date('Y-m-d H:i:s', time());

        $userReportLog = UserOrderFactory::createBlackList($data);

        if (!$userReportLog) {
            $this->error['error'] = "您好，报告记录关系异常！";
            return false;
        }
        return true;
    }
}
