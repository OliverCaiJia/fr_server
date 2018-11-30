<?php

namespace App\Models\Chain\Report\Scopion;

use App\Constants\OrderConstant;
use App\Helpers\Logger\SLogger;
use App\Helpers\Utils;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;

class CreatePersonalAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '订单状态不合法，审核（拒绝）失败！', 'code' => 8210];

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function handleRequest()
    {
        if ($this->createPersonal($this->params)) {
            $this->setSuccessor(new UpdateUserInfoStatusAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    private function createPersonal($params)
    {
        SLogger::getStream()->error(__CLASS__);

        $data['user_id'] = $params['user_id'];
        $data['idcard'] = $params['personal_idcard'];
        $data['idcard_location'] = $params['personal_idcard_location'];
        $data['mobile'] = $params['personal_mobile'];
        $data['carrier'] = $params['personal_carrier'];
        $data['mobile_location'] = $params['personal_mobile_location'];
        $data['name'] = $params['personal_name'];
        $data['age'] = $params['personal_age'];
        $data['gender'] = $params['personal_gender'];
        $data['email'] = $params['personal_email'];
        $data['education'] = $params['personal_education'];
        $data['is_graduation'] = $params['personal_is_graduation'];
        $data['create_at'] = date('Y-m-d H:i:s', time());
        $data['create_ip'] = Utils::ipAddress();
        $data['update_at'] = date('Y-m-d H:i:s', time());
        $data['update_ip'] = Utils::ipAddress();

        $result = UserOrderFactory::createPersonal($data);

        if ($result) {
            return $result;
        }
        return $this->error;
    }
}
