<?php

namespace App\Models\Chain\Order\Pass;

use App\Models\Chain\AbstractHandler;
use App\Helpers\Logger\SLogger;
use DB;

class DoPassOrderHandler extends AbstractHandler
{
    #外部传参

    private $params = array();

    public function __construct($params)
    {
        $this->params = $params;
        $this->setSuccessor($this);
    }

    /**
     * 思路：
     * 1.检查订单状态是否合法
     * 2.更新订单状态
     * 3.触发广播事件，记录履历
     */

    /**
     * 入口
     *
     * @return array
     * @throws \Exception
     */
    public function handleRequest()
    {
        $result = ['error' => '审核（通过）出错啦', 'code' => 8100];
        DB::beginTransaction();
        try {
            $this->setSuccessor(new CheckOrderStatusAction($this->params));
            $result = $this->getSuccessor()->handleRequest();
            if (isset($result['error'])) {
                DB::rollback();
                SLogger::getStream()->error('审核（通过）订单, 事务异常-try');
                SLogger::getStream()->error($result['error']);
            } else {
                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            SLogger::getStream()->error('审核（通过）订单, 事务异常-catch');
            SLogger::getStream()->error($e->getMessage());
        }
        return $result;
    }
}
