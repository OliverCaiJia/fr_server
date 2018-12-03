<?php

namespace App\Models\Chain\Order\NoPayOrder\LoanOrder;

use App\Helpers\Logger\SLogger;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserinfoFactory;

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
        SLogger::getStream()->error(__CLASS__);

        //todo::
        $data['service_status'] = 4;
        $data['update_at'] = date('Y-m-d H:i:s', time());
        $result = UserinfoFactory::UpdateUserInfoStatus($this->params['user_id'], $data);
        if ($result) {
            return $result;
        }
        return $this->error;
    }
}
