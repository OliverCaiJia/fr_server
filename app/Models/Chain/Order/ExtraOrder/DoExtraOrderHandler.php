<?php

namespace App\Models\Chain\Order\PayOrder\UserOrder;

use App\Helpers\Logger\SLogger;
use App\Models\Chain\AbstractHandler;
use Illuminate\Support\Facades\DB;

/**
 * 会员订单创建责任链
 */
class DoExtraOrderHandler extends AbstractHandler
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
     * 1、先入report_log表
     * 2、再入order_report 中间表
     * 3、检查是否有同类型未支付的订单，
     * 4、验证金额  >0
     * 5、验证数量  必须是1
     * 6、创建订单（有效期1小时，）
     */

    public function handleRequest()
    {
        $result = ['error' => '同步失败', 'code' => 1000];

        DB::beginTransaction();
        try
        {
            $this->setSuccessor(new CheckOrderExistsAction($this->params));
            $result = $this->getSuccessor()->handleRequest();
            if (isset($result['error']))
            {
                DB::rollback();

                SLogger::getStream()->error('付费订单失败, 付费订单-try');
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

            SLogger::getStream()->error('付费订单捕获异常, 付费订单-catch');
            SLogger::getStream()->error($e->getMessage());
        }

        return $result;
    }

}
