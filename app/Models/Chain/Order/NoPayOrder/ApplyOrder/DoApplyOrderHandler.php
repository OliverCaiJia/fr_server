<?php

namespace App\Models\Chain\Order\NoPayOrder\ApplyOrder;

use App\Helpers\Logger\SLogger;
use App\Models\Chain\AbstractHandler;
use Illuminate\Support\Facades\DB;

/**
 * 贷款订单责任链
 * Class DoReportOrderLogicHandler
 * @package App\Models\Chain\Order\ReportOrder
 */
class DoApplyOrderHandler extends AbstractHandler
{
    private $params = array();

    public function __construct($params)
    {
        $this->params = $params;
        $this->setSuccessor($this);
    }

    /**
     * 思路：
     * 0.检查是否支付，
     * 1.
     * 2、
     * 3、
     */

    public function handleRequest()
    {
        $result = ['error' => '同步失败', 'code' => 1000];

        DB::beginTransaction();
        try
        {
            $this->setSuccessor(new IfHasPaidOrderAction($this->params));
            $result = $this->getSuccessor()->handleRequest();
            if (isset($result['error']))
            {
                DB::rollback();

                SLogger::getStream()->error('贷款订单失败, 报告-try');
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

            SLogger::getStream()->error('贷款订单捕获异常, 报告异常-catch');
            SLogger::getStream()->error($e->getMessage());
        }

        return $result;
    }

}
