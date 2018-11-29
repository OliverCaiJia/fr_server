<?php

namespace App\Models\Chain\Report\Scopion;

use App\Helpers\RestResponseFactory;
use App\Helpers\RestUtils;
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
//        if ($this->getParams($this->params)) {
//            return true;
//        }
    }


    private function getParams($params)
    {
        $orderNo = $params['order_no'];
        $userOrder = UserOrderFactory::getUserOrderByOrderNo($orderNo);
        if (!$userOrder){
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1150), 1150);
        }

        $userId = $userOrder['user_id'];
        $userRealName = UserRealnameFactory::fetchUserRealname($userId);
        if (empty($userRealName)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1199), 1199);
        }
        $userAuth = UserAuthFactory::getUserById($userId);
        if (empty($userAuth)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1199), 1199);
        }

        $reportTypeNid = $params['report_type_nid'];
        $reportType = UserReportFactory::getReportTypeByTypeNid($reportTypeNid);

        //todo::
//        $res = [];
//        $res['user_report_type_id'] = $reportType['id'];
//        $res['user_id'] = $userId;
//        $res['order_id'] = $userOrder['id'];
//        $res['user_real_name']['real_name'] = $userRealName['real_name'];
//        $res['user_real_name']['id_card_no'] = $userRealName['id_card_no'];
//        $res['user_auth']['mobile'] = $userAuth['mobile'];


        $this->params['user_report_type_id'] = $reportType['id'];
        $this->params['user_id'] = $userId;
        $this->params['order_id'] = $userOrder['id'];

        //反欺诈
        $antiFraud = MozhangService::o()->getMoZhangContent($userRealName['real_name'], $userRealName['id_card_no'], $userAuth['mobile'], 'anti-fraud');
        $this->params['anti_fraud'] = $antiFraud;
        $this->params['report_data']['anti_fraud'] = $antiFraud['data'];
        //申请准入
        $apply = MozhangService::o()->getMoZhangContent($userRealName['real_name'], $userRealName['id_card_no'], $userAuth['mobile'], 'application');

        $this->params['application'] = $apply;
        $this->params['report_data']['application'] = $apply['data'];

        //魔杖2.0系列-额度评估(账户)
        //todo::
//        $credidtEvaluation = MozhangService::o()->getMoZhangContent($userRealName['real_name'], $userRealName['id_card_no'], $userAuth['mobile'], 'evaluation');
//        dd($credidtEvaluation);
//        $this->params['credit_evaluation'] = $credidtEvaluation;
//        $this->params['report_data']['credit_evaluation'] = $credidtEvaluation['data'];

        //额度评估(电商)
        $credidtQualification = MozhangService::o()->getMoZhangContent($userRealName['real_name'], $userRealName['id_card_no'], $userAuth['mobile'], 'credit.qualification');

        $this->params['credit_qualification'] = $credidtQualification;
        $this->params['report_data']['credit_qualification'] = $credidtQualification['data'];

        //贷后行为
        $postLoad = MozhangService::o()->getMoZhangContent($userRealName['real_name'], $userRealName['id_card_no'], $userAuth['mobile'], 'post-load');

        $this->params['post_load'] = $postLoad;
        $this->params['report_data']['post_load'] = $postLoad['data'];
        //黑灰名单
        $blackGray = MozhangService::o()->getMoZhangContent($userRealName['real_name'], $userRealName['id_card_no'], $userAuth['mobile'], 'black-gray');

        $this->params['black_gray'] = $blackGray;
        $this->params['report_data']['black_gray'] = $blackGray['data'];
        //多头报告
        $multiinfo = MozhangService::o()->getMoZhangContent($userRealName['real_name'], $userRealName['id_card_no'], $userAuth['mobile'], 'multi-info');

        $this->params['multi_info'] = $multiinfo;
        $this->params['report_data']['multi_info'] = $multiinfo['data'];

        if (!$orderNo) {
            $this->error['error'] = "您好，报告记录关系异常！";
            return false;
        }
        return true;
    }
}
