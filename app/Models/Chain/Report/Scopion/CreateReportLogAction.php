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

        if (empty($params['anti_fraud'])) {
            $this->error['error'] = '未找到反欺诈信息';
            return false;
        }
        $reportLog['data'] = json_encode($params['anti_fraud']);
        $reportLog = UserOrderFactory::createReportLog($reportLog);


        if (empty($params['application'])) {
            $this->error['error'] = '未找到申请准入信息';
            return false;
        }
        $reportLog['data'] = json_encode($params['application']);
        $reportLog = UserOrderFactory::createReportLog($reportLog);

        if (empty($params['credit_qualification'])) {
            $this->error['error'] = '未找到额度评估(电商)信息';
            return false;
        }
        $reportLog['data'] = json_encode($params['credit_qualification']);
        $reportLog = UserOrderFactory::createReportLog($reportLog);

        if (empty($params['post_load'])) {
            $this->error['error'] = '未找到贷后行为信息';
            return false;
        }
        $reportLog['data'] = json_encode($params['post_load']);
        $reportLog = UserOrderFactory::createReportLog($reportLog);

        if (empty($params['black_gray'])) {
            $this->error['error'] = '未找到黑灰名单';
            return false;
        }
        $reportLog['data'] = json_encode($params['black_gray']);
        $reportLog = UserOrderFactory::createReportLog($reportLog);

        if (empty($params['multi_info'])) {
            $this->error['error'] = '未找到多头报告';
            return false;
        }
        $reportLog['data'] = json_encode($params['multi_info']);
        $reportLog = UserOrderFactory::createReportLog($reportLog);

        if (!$reportLog) {
            $this->error['error'] = "您好，用户报告报告录入异常！";
            return false;
        }
        return true;
    }
}
