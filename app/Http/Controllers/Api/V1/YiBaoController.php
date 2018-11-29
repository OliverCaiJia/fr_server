<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\RestResponseFactory;
use App\Helpers\RestUtils;
use App\Helpers\Logger\SLogger;
use App\Http\Controllers\Api\ApiController;
use App\Models\Chain\Order\NoPayOrder\ApplyOrder\DoApplyOrderHandler;
use App\Models\Chain\Order\PayOrder\PaidOrder\DoPaidOrderHandler;
use Illuminate\Http\Request;
use App\Strategies\PaymentStrategy;
use App\Models\Factory\Api\UserOrderFactory;
use App\Services\Core\Payment\YiBao\YiBaoConfig;
use App\Services\Core\Payment\YiBao\YopSignUtils;
use App\Models\Chain\Report\Scopion\DoReportOrderHandler;
use Illuminate\Support\Facades\DB;


class YiBaoController extends ApiController
{
    /**
     * 获取账户信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
//    public  function sync(Request $request)
//    {
//        $params = $request->input('orderId');
//    }

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
            //记录
            //1.payment_log
            //2.user_account_log记录 修改user_account主表
            //3.
        }
        catch (\Exception $e)
        {
            //订单异常事务回滚
            DB::rollBack();
            //异常日志记录
            SLogger::getStream()->error('支付回调, 支付回调订单-catch');
            SLogger::getStream()->error($e->getMessage());
            return 'ERROR';
        }
        //事务提交
        DB::commit();
        return 'SUCCESS';

    }
}