<?php

namespace App\Models\Chain\Report\Scopion;

use App\Constants\OrderConstant;
use App\Helpers\Logger\SLogger;
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
    }

    private function createReportLog($params)
    {
        SLogger::getStream()->error(__CLASS__);

        $reportLog['user_report_type_id'] = $params['user_report_type_id'];
        $reportLog['user_id'] = $params['user_id'];
        $reportLog['order_id'] = $params['order_id'];
        $reportLog['status'] = 1;//支付成功状态为一
        $reportLog['create_at'] = date('Y-m-d H:i:s', time());
        $reportLog['create_ip'] = Utils::ipAddress();
        $reportLog['update_at'] = date('Y-m-d H:i:s', time());
        $reportLog['update_ip'] = Utils::ipAddress();

        /**
         * 反欺诈
         */
        if (isset($params['anti_fraud'])) {
            $reportLog['data'] = json_encode($params['anti_fraud']);
            $reportLog = UserOrderFactory::createReportLog($reportLog);

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

            UserOrderFactory::createAntifraud($antifraud);
        }

        /**
         * 申请准入
         */
        if (isset($params['application'])) {
            $reportLog['data'] = json_encode($params['application']);
            $reportLog = UserOrderFactory::createReportLog($reportLog);
        }
        /**
         * 魔杖2.0系列-额度评估(账户)
         */
        if (isset($params['credit_evaluation'])) {
            $reportLog['data'] = json_encode($params['credit_evaluation']);
            $reportLog = UserOrderFactory::createReportLog($reportLog);
        }
        /**
         *额度评估(电商)
         */
        if (isset($params['credit_qualification'])) {
            $reportLog['data'] = json_encode($params['credit_qualification']);
            $reportLog = UserOrderFactory::createReportLog($reportLog);
        }
        /**
         *贷后行为
         */
        if (isset($params['post_load'])) {
            $reportLog['data'] = json_encode($params['post_load']);
            $reportLog = UserOrderFactory::createReportLog($reportLog);
        }
        /**
         *黑灰名单
         */
        if (isset($params['black_gray'])) {
            $reportLog['data'] = json_encode($params['black_gray']);
            $reportLog = UserOrderFactory::createReportLog($reportLog);
        }
        /**
         *多头报告
         */
        if (isset($params['multi_info'])) {
            $reportLog['data'] = json_encode($params['multi_info']);
            $reportLog = UserOrderFactory::createReportLog($reportLog);
        }

        return true;
    }
}
