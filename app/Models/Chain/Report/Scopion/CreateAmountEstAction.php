<?php

namespace App\Models\Chain\Report\Scopion;

use App\Constants\OrderConstant;
use App\Helpers\Logger\SLogger;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;

class CreateAmountEstAction extends AbstractHandler
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
        if ($this->createAmountEst($this->params)) {
            $this->setSuccessor(new CreatePostLoanAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    private function createAmountEst($params)
    {
        SLogger::getStream()->error(__CLASS__);

        $data['user_id'] = $params['user_id'];
        $data['user_report_id'] = $params['user_report_id'];
        $data['zm_score'] = $params['credit_qualification']['data']['qualification_info']['zm_score_info']['zm_score'];
        $data['huabai_limit'] = $params['credit_qualification']['data']['qualification_info']['huabei_info']['huabai_limit'];
        $data['credit_amt'] = $params['credit_qualification']['data']['qualification_info']['jiebei_info']['credit_amt'];
        $data['data'] = json_encode($params['credit_qualification']['data']);
        $data['fee'] = $params['credit_qualification']['fee'];
        $data['create_at'] = date('Y-m-d H:i:s', time());
        $data['update_at'] = date('Y-m-d H:i:s', time());

        $userAmountEst = UserOrderFactory::createAmountEst($data);

        $this->params['personal_idcard'] = $params['credit_qualification']['data']['person_info']['idcard'];
        $this->params['personal_idcard_location'] = $params['credit_qualification']['data']['person_info']['idcard_location'];
        $this->params['personal_mobile'] = $params['credit_qualification']['data']['person_info']['mobile'];
        $this->params['personal_carrier'] = $params['credit_qualification']['data']['person_info']['carrier'];
        $this->params['personal_mobile_location'] = $params['credit_qualification']['data']['person_info']['mobile_location'];
        $this->params['personal_name'] = $params['credit_qualification']['data']['person_info']['name'];
        $this->params['personal_age'] = $params['credit_qualification']['data']['person_info']['age'];
        $this->params['personal_gender'] = $params['credit_qualification']['data']['person_info']['gender'];
        $this->params['personal_email'] = $params['credit_qualification']['data']['person_info']['email'];
        $this->params['personal_education'] = $params['credit_qualification']['data']['person_info']['education_info']['level'];
        $this->params['personal_is_graduation'] = (int)$params['credit_qualification']['data']['person_info']['education_info']['is_graduation'];

        if (!$userAmountEst) {
            $this->error['error'] = "您好，报告记录关系异常！";
            return false;
        }
        return true;
    }
}
