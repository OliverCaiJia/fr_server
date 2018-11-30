<?php

namespace App\Models\Chain\Report\Scopion;

use App\Helpers\Logger\SLogger;
use App\Models\Chain\AbstractHandler;
use App\Models\Chain\Report\Scopion\CreateAntifraudAction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class DoReportOrderHandler extends AbstractHandler
{
    private $params = array();

    public function __construct($params)
    {
        $this->params = $params;
        $this->setSuccessor($this);
    }

    /**
     * 思路：
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
            $this->setSuccessor(new GetLogParamAction($this->params));
            $result = $this->getSuccessor()->handleRequest();
            if (isset($result['error']))
            {
                DB::rollback();

                SLogger::getStream()->error('报告订单失败, 报告-try');
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
            
            Log::error($e);

            SLogger::getStream()->error('报告订单捕获异常, 报告异常-catch');
            SLogger::getStream()->error($e->getMessage());
        }

        return $result;
    }

}
