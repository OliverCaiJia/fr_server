<?php

namespace App\Models\Chain\Report\Scopion;

use App\Helpers\Logger\SLogger;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserAuthFactory;
use App\Models\Factory\Api\UserOrderFactory;
use App\Models\Factory\Api\UserRealnameFactory;
use App\Models\Factory\Api\UserReportFactory;
use App\Services\Core\Validator\Scorpion\Mozhang\MozhangService;

class GetLogParamAction extends AbstractHandler
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
        if ($this->getParams($this->params)) {
            $this->setSuccessor(new CreateReportLogAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }


    private function getParams($params)
    {
        SLogger::getStream()->info(__CLASS__);
        //查询订单
        $orderNo = $params['order_no'];
        if (!$orderNo) {
            $this->error['error'] = "您好，报告记录关系异常！";
            return false;
        }
        $userOrder = UserOrderFactory::getUserOrderByOrderNo($orderNo);
        if (!$userOrder) {
            $this->error['error'] = '未找到该订单';
            return false;
        }
        //查询实名信息
        $userId = $userOrder['user_id'];
        $userRealName = UserRealnameFactory::fetchUserRealname($userId);
        if (empty($userRealName)) {
            $this->error['error'] = '未找到该实名用户';
            return false;
        }
        //查询认证用户信息
        $userAuth = UserAuthFactory::getUserById($userId);
        if (empty($userAuth)) {
            $this->error['error'] = '未找到该认证用户';
            return false;
        }

        $reportTypeNid = $params['report_type_nid'];
        //查询报告雷类型
        $reportType = UserReportFactory::getReportTypeByTypeNid($reportTypeNid);

        $this->params['user_report_type_id'] = $reportType['id'];
        $this->params['user_id'] = $userId;
        $this->params['order_id'] = $userOrder['id'];
        $this->params['report_data'] = [];
        /**
         * 反欺诈
         */
        $antiFraud = MozhangService::o()->getMoZhangContent($userRealName['real_name'], $userRealName['id_card_no'], $userAuth['mobile'], 'anti-fraud');
        if (isset($antiFraud['data'])) {
            $this->params['anti_fraud'] = $antiFraud;
            $this->params['report_data']['anti_fraud'] = $antiFraud['data'];
        }

        /**
         * 申请准入
         */
        $apply = MozhangService::o()->getMoZhangContent($userRealName['real_name'], $userRealName['id_card_no'], $userAuth['mobile'], 'application');
        if (isset($apply['data'])) {
            $this->params['application'] = $apply;
            $this->params['report_data']['application'] = $apply['data'];
        }

        /**
         * 魔杖2.0系列-额度评估(账户)
         */
        $credidtEvaluation = MozhangService::o()->getMoZhangContent($userRealName['real_name'], $userRealName['id_card_no'], $userAuth['mobile'], 'evaluation');
//        array:5 [
//        "success" => true
//  "code" => "0000"
//  "msg" => "操作成功"
//  "data" => array:4 [
//        "trans_id" => "1f7788d0-fc79-11e8-b5a5-00163e0da63a"
//    "person_info" => array:10 [
//        "idcard" => "13070219811107****"
//      "idcard_location" => "河北省/张家口市/桥东区"
//      "mobile" => "1851053****"
//      "carrier" => "中国联通"
//      "mobile_location" => "北京/北京"
//      "name" => "蔡*"
//      "age" => 37
//      "gender" => "男"
//      "email" => ""
//      "education_info" => array:2 [
//        "level" => 0
//        "is_graduation" => false
//      ]
//    ]
//    "fund_infos" => []
//    "bank_infos" => array:2 [
//        "debit_card_info" => array:9 [
//        "update_date" => ""
//        "card_amount" => 0
//        "balance" => ""
//        "total_income" => ""
//        "total_salary_income" => ""
//        "total_loan_income" => ""
//        "total_outcome" => ""
//        "total_consume_outcome" => ""
//        "total_loan_outcome" => ""
//      ]
//      "credit_card_info" => array:7 [
//        "update_date" => ""
//        "card_amount" => 0
//        "total_credit_limit" => ""
//        "total_credit_available" => ""
//        "max_credit_limit" => ""
//        "overdue_times" => 0
//        "overdue_months" => 0
//      ]
//    ]
//  ]
//  "fee" => "N"
//]
        if (isset($credidtEvaluation['data'])) {
            $this->params['credit_evaluation'] = $credidtEvaluation;
            $this->params['report_data']['credit_evaluation'] = $credidtEvaluation['data'];
        }

        /**
         * 额度评估(电商)
         */
        $credidtQualification = MozhangService::o()->getMoZhangContent($userRealName['real_name'], $userRealName['id_card_no'], $userAuth['mobile'], 'credit.qualification');
//        dd($credidtQualification);//ok
        if (isset($credidtQualification['data'])) {
            $this->params['credit_qualification'] = $credidtQualification;
            $this->params['report_data']['credit_qualification'] = $credidtQualification['data'];
        }

        /**
         * 贷后行为
         */
        $postLoad = MozhangService::o()->getMoZhangContent($userRealName['real_name'], $userRealName['id_card_no'], $userAuth['mobile'], 'post-load');
//        dd($postLoad);//ok
        if (isset($postLoad['data'])) {
            $this->params['post_load'] = $postLoad;
            $this->params['report_data']['post_load'] = $postLoad['data'];
        }
        /**
         * 黑灰名单
         */
        $blackGray = MozhangService::o()->getMoZhangContent($userRealName['real_name'], $userRealName['id_card_no'], $userAuth['mobile'], 'black-gray');
        if (isset($blackGray['data'])) {
            $this->params['black_gray'] = $blackGray;
            $this->params['report_data']['black_gray'] = $blackGray['data'];
        }
        /**
         * 多头报告
         */
        $multiinfo = MozhangService::o()->getMoZhangContent($userRealName['real_name'], $userRealName['id_card_no'], $userAuth['mobile'], 'multi-info');
        if (isset($multiinfo['data'])) {
            $this->params['multi_info'] = $multiinfo;
            $this->params['report_data']['multi_info'] = $multiinfo['data'];
        }
        return true;
    }
}
