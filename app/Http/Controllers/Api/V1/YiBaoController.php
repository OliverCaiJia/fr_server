<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\RestResponseFactory;
use App\Helpers\RestUtils;
use App\Helpers\Logger\SLogger;
use App\Http\Controllers\Api\ApiController;
use App\Models\Chain\Order\NoPayOrder\LoanOrder\DoApplyOrderHandler;
use App\Models\Chain\Order\PayOrder\PaidOrder\DoPaidOrderHandler;
use Illuminate\Http\Request;
use App\Strategies\PaymentStrategy;
use App\Models\Factory\Api\UserOrderFactory;
use App\Services\Core\Payment\YiBao\YiBaoConfig;
use App\Services\Core\Payment\YiBao\YopSignUtils;
use App\Models\Chain\Report\Scopion\DoReportOrderHandler;


class YiBaoController extends ApiController
{
    /**
     * 获取账户信息
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
//        $params = 'YlSF1S-nELF4fmY15A_n3wLnEnB4Pn9PuqCuoEa72IashWAhLLnQdlrtJIFqwlAX8fBUYK4oQ8AbQGBAuwyXGXYPZx6nz7G6UIbRrQuPafmNvfXeFlE-UR1INgdPv9wVZQ9GNLiOn0o4mar4JacIaeLmY_LJQ_ir8bfvDqTeAEz34W0zuXyNFnoPlp72OXYimdBL06o3S5XqmOdyc3xHkolbzUSHV-XVET-Ymwa0ESQOgLXBAHh0vtMWniP87VFROQM-Pzqz-HPN_9136AeP8Imt1vEf4D0EYRFLA_Ohu3p2CeGcBgSMOR6xKzrtRN_PwHB6v8Z-MeBUs2mNIDGsKA$JcWHAXfl4coBrBfU_ygpDTNMfqiRu7-r5aAU33uIYqCeSn1NEU3KngjkQKtsvXkcs2O-VotSdGJtXl1pPpEWBQEP-OhVXEyJi1hCah_JtNcvhdtTm2EuEbG3oycjZt671gtN4NvpFwa9EOHkiqbNkKy9jkVDbx13s00a9pq6cIE3AOwuOexZbZIJ8qGSiWQaa_2oBtqVtC8Dvd89lKucn9PPfqttJoMhowRy80IcpzEl-yqwJpeYG7tgii4MV_PN2TASLg1K6vg53Gudsv6y-BIQcZrdUYsufTdYcoMq9b5CneI4RGhCCQhc0job8wMgIQo5jTTpE0Sv5QFx5vdKMOZ15-gHMuE8PB93xqZSxYDBCMMw_hWGPXJPwKIvz1XkJC0gO1oqOg557vtdWhsaUMBxgjd9BcQ4LUbVjeHgpFHv75H9CdK2vIgv_-gCmuTgLQzopz6frDprniDDr_8DzPWAQMiY3Tb3pTin-iQxpxbzhaf0pXeJlAsblz-JUp-ynW6yZBVNc3D-SRztnWvcXUvvA_dKmnGGV9a5IgAsbgV_nWkn-eIErA5rC68ktxyTVJIavPZcFWApb7kOYAY44jT6v1JXe4VIu5i2B-XKLwWtL5BXmvxF7BShCtEa5G7n5a59cqdvb6ry13w8O6tBf5ePivaUi2zqKrv0WrL2lNdXL3caiCSXSYDcWRYxtdPaqblPfgEjD6fjIdCqscN_dtjEZ7_lGp5gwssJOH59j8Zz2TUmOcp1KoNzpxP-b_dfLDE63Kf8DZg0KJKH4IL7w1oDPE8X8K0FwTqWSx5fJWscBxFR2Cb_AwgaTZRM42-oH6y51_AXBmctMdNZ1Mpf6PPSKXczlva8uV7Tb0euPyy1D90SWLuyjXQH6CfOeo896jTneYd9A46QKvo2l3tleuExyQZFLyfqEiPVUjPkjzCcST9WVHDSrfO96QMdJA5LVCimPiotg1XTsocRmGhSgjrI6kvsY2f1pSW0u2NBPQL962fJp5mnivhScZhr8_ZfY0wFVf6yhjr8IwnyCLI0qbDdi_sEy0fRD5kRd6sezO_0Uszf4KkNOjox2P1HITByw3BUgHcYNwLo9xFHgxiM4NIqIBgKzXwY8GQwrfWOH7Nc5rKFbPUY1OaduMXO5g7iBaeK189xvULrqHklkJmbglkDy4APSiC4BN4oA-nMrZ91ITMMmCu-zHNkrpto1pWY$AES$SHA256';
//        $public_key = YiBaoConfig::YOP_PUBLIC_KEY;
//        $private_key = YiBaoConfig::PRIVATE_KEY;
//        $resData = YopSignUtils::decrypt($params,$private_key,$public_key);
//        $resData = json_decode($resData,true);
        //            if($reportRes){
//
//            }
        //处理订单信息
//        $data['order_no'] = $resData['orderId'];
//        $data['order_no'] = 'SGD-A-20181119220855-178027';
//        $res = PaymentStrategy::getDiffOrderTypeChain($data);
//        dd($res);
        $params = $request->input('response');
        $public_key = YiBaoConfig::YOP_PUBLIC_KEY;
        $private_key = YiBaoConfig::PRIVATE_KEY;
        $resData = YopSignUtils::decrypt($params,$private_key,$public_key);
        $resData = json_decode($resData,true);
        $data['order_no'] = $resData['orderId'];

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

        return 'SUCCESS';
    }
}