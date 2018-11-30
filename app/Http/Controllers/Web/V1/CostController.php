<?php

namespace App\Http\Controllers\Web\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Web\WebController;
use App\Helpers\RestResponseFactory;
use App\Models\Factory\FeeFactory;


class CostController extends WebController
{
    /**
     * 推荐服务列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function costDefault(Request $request)
    {
        $token = $this->getToken($request);
        $fee_res = FeeFactory::getFeeByFeeNid('CREDIT_COST_DEFAULT');

        $data['groom'] = [
            'seq_no' => $fee_res['seq_no'],
            'name' => $fee_res['name'],
            'remark' => $fee_res['remark'],
            'price' => $fee_res['price'],
            'old_price' => $fee_res['old_price'],
        ];
        $data['time_limit'] = [
            [
                'seq_no' => 1,
                'name' => '借款  1000元/七天',
                'remark' => '放款快,周期长,利率低',
                'price' => 0,
                'old_price' => 88,
                'seq_nid' => '1000_7days',
            ],
            [
                'seq_no' => 2,
                'name' => '借款  500元/七天',
                'remark' => '放款快,周期长,利率低',
                'price' => 0,
                'old_price' => 50,
                'seq_nid' => '500_7days',
            ],
            [
                'seq_no' => 3,
                'name' => '借款  1000元/14天',
                'remark' => '放款快,周期长,利率低',
                'price' => 0,
                'old_price' => 148,
                'seq_nid' => '1000_14days',
            ],
        ];
        return view('web.cost.costdefault', compact('data','token'));
    }
}
