<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Logger\SLogger;
use App\Http\Controllers\Api\ApiController;
use App\Models\Chain\Order\NoPayOrder\LoanOrder\DoApplyOrderHandler;
use App\Models\Chain\Order\PayOrder\PaidOrder\DoPaidOrderHandler;
use App\Models\Chain\Payment\PaymentAccount\DoPaymentAccountHandler;
use Illuminate\Http\Request;
use App\Services\Core\Payment\YiBao\YiBaoConfig;
use App\Services\Core\Payment\YiBao\YopSignUtils;
use App\Models\Chain\Report\Scopion\DoReportOrderHandler;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class YiBaoController
 * @package App\Http\Controllers\Api\V1
 * 易宝回调
 */
class YiBaoController extends ApiController
{
    /**
     * 易宝同步回调
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public  function sync(Request $request)
    {
        return 'ERROR';
    }

    /**
     * 易宝异步回调
     * @param Request $request
     * @return string
     */
    public function async(Request $request)
    {
        //获取回调结果
        $params = $request->input('response');
        //获取配置信息
        $public_key = YiBaoConfig::YOP_PUBLIC_KEY;
        $private_key = YiBaoConfig::PRIVATE_KEY;
        $resData = YopSignUtils::decrypt($params,$private_key,$public_key);
        $resData = json_decode($resData,true);
        //订单支付成功
        if($resData['status'] != 'SUCCESS'){
            return 'ERROR';
        }
        //获取订单编号
        $data['order_no'] = $resData['orderId'];
        //事务处理
        DB::beginTransaction();
        try
        {
            //修改订单状态
            $orderTypeChain = new DoPaidOrderHandler($data);
            $typeRes = $orderTypeChain->handleRequest();
            if(isset($typeRes['error'])){
                return 'ERROR';
            }

            //生成信用报告
            $data['report_type_nid'] = $typeRes['report_type_nid'];
            $reportChain = new DoReportOrderHandler($data);
            $reportRes = $reportChain->handleRequest();
            if(isset($reportRes['error'])){
                return 'ERROR';
            }

            //推送一键贷
            $task = new DoApplyOrderHandler($data);
            $taskRes = $task->handleRequest();
            if(isset($taskRes['error'])){
                return 'ERROR';
            }
        }
        catch (\Exception $e)
        {
            //订单异常事务回滚
            DB::rollBack();
            Log::error($e);
            //异常日志记录
            SLogger::getStream()->error('支付回调, 支付回调订单-catch');
            SLogger::getStream()->error($e->getMessage());
            return 'ERROR';
        }
        //事务提交
        DB::commit();

        //记录
        $paymentChain = new DoPaymentAccountHandler($resData);
        $paymentChain->handleRequest();

        return 'SUCCESS';

    }
}