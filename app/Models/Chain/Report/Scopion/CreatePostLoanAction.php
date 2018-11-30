<?php

namespace App\Models\Chain\Report\Scopion;

use App\Constants\OrderConstant;
use App\Helpers\Logger\SLogger;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;

class CreatePostLoanAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '订单状态不合法，审核（拒绝）失败！', 'code' => 8210];

    public function     __construct($params)
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
        if ($this->createPostloan($this->params)) {
            $this->setSuccessor(new CreateBlackListAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    private function createPostloan($params)
    {
        SLogger::getStream()->error(__CLASS__);

        $data['user_id'] = $params['user_id'];
        $data['user_report_id'] = $params['user_report_id'];
        $data['transid'] = $params['post_load']['data']['trans_id'];
        $data['due_days_non_cdq_12_mon'] = $params['post_load']['data']['loan_behavior_analysis']['feature_360d']['last_to_end_sure_due_non_cdq_all_time_m12'];
        $data['pay_cnt_12_mon'] = $params['post_load']['data']['loan_behavior_analysis']['feature_360d']['sum_pay_cnt_all_pro_all_time_m12'];
        $data['data'] = json_encode($params['post_load']['data']);
        $data['fee'] = $params['post_load']['fee'];
        $data['create_at'] = date('Y-m-d H:i:s', time());
        $data['update_at'] = date('Y-m-d H:i:s', time());

        $userPostLoan = UserOrderFactory::createPostloan($data);

        if (!$userPostLoan) {
            $this->error['error'] = "您好，报告记录关系异常！";
            return false;
        }
        return true;
    }
}
