<?php

namespace App\Models\Chain\Report\Scopion;

use App\Constants\OrderConstant;
use App\Helpers\Logger\SLogger;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;
use App\Services\Core\Validator\Scorpion\Mozhang\MozhangService;

class CreateAntifraudAction extends AbstractHandler
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
        if ($this->createAntifraud($this->params)) {
            $this->setSuccessor(new CreateApplyAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }


    private function createAntifraud($params)
    {
        SLogger::getStream()->error(__CLASS__);

        $antifraud['user_id'] = $params['user_id'];
        $antifraud['user_report_id'] = $params['user_report_id'];
        $antifraud['courtcase_cnt'] = isset($params['anti_fraud']['data']['untrusted_info']['courtcase_cnt']) ? $params['anti_fraud']['data']['untrusted_info']['courtcase_cnt'] : '';
        $antifraud['dishonest_cnt'] = isset($params['anti_fraud']['data']['untrusted_info']['dishonest_cnt']) ? $params['anti_fraud']['data']['untrusted_info']['dishonest_cnt'] : '';
        $antifraud['fraudulence_is_hit'] = intval(isset($params['anti_fraud']['data']['fraudulence_info']['is_hit'])) ? $params['anti_fraud']['data']['fraudulence_info']['is_hit'] : 0;
        $antifraud['untrusted_info'] = json_encode(isset($params['anti_fraud']['data']['untrusted_info']) ? $params['anti_fraud']['data']['untrusted_info'] : []);
        $antifraud['suspicious_idcard'] = json_encode(isset($params['anti_fraud']['data']['suspicious_idcard']) ? $params['anti_fraud']['data']['suspicious_idcard'] : []);
        $antifraud['suspicious_mobile'] = json_encode(isset($params['anti_fraud']['data']['suspicious_mobile']) ? $params['anti_fraud']['data']['suspicious_mobile'] : []);
        $antifraud['data'] = json_encode(isset($params['anti_fraud']['data']) ? $params['anti_fraud']['data'] : []);
        $antifraud['fee'] = isset($params['anti_fraud']['fee']) ? $params['anti_fraud']['fee'] : '';
        $antifraud['create_at'] = date('Y-m-d H:i:s', time());
        $antifraud['update_at'] = date('Y-m-d H:i:s', time());

        $antifraud = UserOrderFactory::createAntifraud($antifraud);
        if (!$antifraud) {
            $this->error['error'] = "您好，报告记录关系异常！";
            return false;
        }
        return true;
    }
}
