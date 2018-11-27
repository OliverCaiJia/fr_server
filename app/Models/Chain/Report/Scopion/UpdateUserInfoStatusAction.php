<?php

namespace App\Models\Chain\Report\Scopion;

use App\Constants\OrderConstant;
use App\Helpers\Utils;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserinfoFactory;
use App\Models\Factory\Api\UserOrderFactory;

class UpdateUserInfoStatusAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '订单状态不合法，审核（拒绝）失败！', 'code' => 8210];

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function handleRequest()
    {
        $data['service_status'] = 3;
        $result = UserinfoFactory::UpdateUserInfoStatus($this->params['user_id'], $data);
        if ($result) {
            return $result;
        }
        return $this->error;
    }
}
