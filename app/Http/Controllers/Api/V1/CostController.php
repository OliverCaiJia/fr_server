<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\RestResponseFactory;
use App\Http\Controllers\Api\ApiController;
use App\Models\Factory\FeeFactory;
use Illuminate\Http\Request;
use App\Helpers\RestUtils;


/**
 *推荐服务
 */
class CostController extends ApiController
{
    /**
     *推荐服务默认配置
     */
    public function costDefault(Request $request)
    {
        $fee_nid = $request->fee_nid ? $request->fee_nid : '';
        if(!$fee_nid){
            return RestResponseFactory::ok(RestUtils::getStdObj(), '参数错误',1000);
        }
        $fee_res = FeeFactory::getFeeByFeeNid($fee_nid);
        if(!$fee_res){
            return RestResponseFactory::ok(RestUtils::getStdObj(), '暂无数据',1005);
        }
        $re['groom'] = [
            [
                'seq_no' => $fee_res['seq_no'],
                'name' => $fee_res['name'],
                'remark' => $fee_res['remark'],
                'price' => $fee_res['price'],
                'old_price' => $fee_res['old_price'],
            ],
        ];
        if($fee_nid == 'CREDIT_COST_DEFAULT'){
            $re['time_limit'] = [
                [
                    'seq_no' => 1,
                    'name' => '借款  1000元/七天',
                    'remark' => '放款快,周期长,利率低',
                    'price' => 0,
                    'old_price' => 88,
                ],
                [
                    'seq_no' => 2,
                    'name' => '借款  500元/七天',
                    'remark' => '放款快,周期长,利率低',
                    'price' => 0,
                    'old_price' => 50,
                ],
                [
                    'seq_no' => 3,
                    'name' => '借款  1000元/14天',
                    'remark' => '放款快,周期长,利率低',
                    'price' => 0,
                    'old_price' => 148,
                ],
            ];
        }

        return RestResponseFactory::ok($re);
    }
}