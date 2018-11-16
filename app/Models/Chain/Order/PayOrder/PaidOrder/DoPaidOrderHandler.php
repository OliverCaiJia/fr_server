<?php

namespace App\Models\Chain\Order\PayOrder\PaidOrder;

use App\Helpers\Logger\SLogger;
use App\Models\Chain\AbstractHandler;
use Illuminate\Support\Facades\DB;


class DoPaidOrderHandler extends AbstractHandler
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
     * 1.订单编号是否存在
     * 2、是否处理中
     * 3、更新订单状态和时间（及其他字段）
     */

    public function handleRequest()
    {
        $result = ['error' => '同步失败', 'code' => 1000];

        DB::beginTransaction();
        try
        {
            $this->setSuccessor(new CheckOrderNoExistsAction($this->params));
            $result = $this->getSuccessor()->handleRequest();
            if (isset($result['error']))
            {
                DB::rollback();

                SLogger::getStream()->error('支付回调订单失败, 支付回调订单-try');
                SLogger::getStream()->error($result['error']);
            }
            else
            {
                DB::commit();

            }
        }
        catch (\Exception $e)
        {
            DB::rollBack();

            SLogger::getStream()->error('支付回调订单捕获异常, 支付回调订单-catch');
            SLogger::getStream()->error($e->getMessage());
        }

        return $result;
    }

}
