<?php

namespace App\Models\Chain\Report\Scopion;

use App\Constants\OrderConstant;
use App\Helpers\Logger\SLogger;
use App\Helpers\Utils;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;
use App\Services\Core\Validator\Scorpion\Mozhang\MozhangService;
use App\Strategies\ReportStrategy;

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
        SLogger::getStream()->error(__CLASS__.'anti_fraud');

        if (isset($params['anti_fraud'])) {
            $reportLog['data'] = json_encode($params['anti_fraud']);
            $reportLog = UserOrderFactory::createReportLog($reportLog);

            $antifraud = ReportStrategy::getAntifraud($params);
            UserOrderFactory::createAntifraud($antifraud);
        }

        /**
         * 申请准入
         */
        SLogger::getStream()->error(__CLASS__.'application');
        if (isset($params['application'])) {
            $reportLog['data'] = json_encode($params['application']);
            $reportLog = UserOrderFactory::createReportLog($reportLog);

            $userApply = ReportStrategy::getApply($params);
            UserOrderFactory::createApply($userApply);
        }
        /**
         * 魔杖2.0系列-额度评估(账户)
         */
        SLogger::getStream()->error(__CLASS__.'credit_evaluation');
        if (isset($params['credit_evaluation'])) {
            $reportLog['data'] = json_encode($params['credit_evaluation']);
            $reportLog = UserOrderFactory::createReportLog($reportLog);
        }
        /**
         *额度评估(电商)
         */
        SLogger::getStream()->error(__CLASS__.'credit_qualification');
        if (isset($params['credit_qualification'])) {
            $reportLog['data'] = json_encode($params['credit_qualification']);

            $reportLog = UserOrderFactory::createReportLog($reportLog);
            $userAmountEst = ReportStrategy::getAmountEst($params);
            SLogger::getStream()->error(__CLASS__.'======'.json_encode($userAmountEst));
            UserOrderFactory::createAmountEst($userAmountEst);
            SLogger::getStream()->error(__CLASS__.'===--------------===');
        }
        /**
         *贷后行为
         */
        SLogger::getStream()->error(__CLASS__.'post_load');
        if (isset($params['post_load'])) {
            $reportLog['data'] = json_encode($params['post_load']);
            $reportLog = UserOrderFactory::createReportLog($reportLog);

            $userPostLoan = ReportStrategy::getPostLoan($params);
            UserOrderFactory::createPostloan($userPostLoan);
        }
        /**
         *黑灰名单
         */
        SLogger::getStream()->error(__CLASS__.'black_gray');
        if (isset($params['black_gray'])) {
            $reportLog['data'] = json_encode($params['black_gray']);
            $reportLog = UserOrderFactory::createReportLog($reportLog);

            $userBlackList = ReportStrategy::getBlackList($params);
            UserOrderFactory::createBlackList($userBlackList);
        }
        /**
         *多头报告
         */
        SLogger::getStream()->error(__CLASS__.'multi_info');
        if (isset($params['multi_info'])) {
            $reportLog['data'] = json_encode($params['multi_info']);
            $reportLog = UserOrderFactory::createReportLog($reportLog);

            $userMultiinfo = ReportStrategy::getMultiInfo($params);
            UserOrderFactory::createMultiinfo($userMultiinfo);
        }

        /**
         * 个人信息
         */
        SLogger::getStream()->error(__CLASS__.'credit_qualification');
        if (isset($params['credit_qualification'])) {
            $userPersonal = ReportStrategy::getPersonal($params);
            UserOrderFactory::createPersonal($userPersonal);
        }

        return true;
    }
}
