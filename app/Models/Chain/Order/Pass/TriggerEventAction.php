<?php

namespace App\Models\Chain\Order\Pass;

use App\Constants\OrderActionLogConstant;
use App\Events\OrderActionEvent;
use App\Models\Chain\AbstractHandler;
use Auth;

class TriggerEventAction extends AbstractHandler
{
    private $params = [];
    protected $error = [
        'error' => '触发广播事件，记录履历失败，分配失败！',
        'code' => 8130
    ];

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * 第三步:触发广播事件，记录履历
     *
     * @return array
     */
    public function handleRequest()
    {
        if ($this->triggerEvent($this->params)) {
            return true;
        } else {
            return $this->error;
        }
    }

    private function triggerEvent($params)
    {
        $admin = Auth::user();
        event(new OrderActionEvent(
            '\App\Models\Admin\Order',
            $params['order_id'],
            OrderActionLogConstant::REVIEW,
            '合作方人员ID：' . $admin->id . '，帐号:' . $admin->username . '审核了订单ID:' .
            $params['saas_order_id'] . '，通过！'
        ));
        return true;
    }
}
