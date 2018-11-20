<?php
namespace App\Http\Controllers\Api\V1;

use App\Helpers\RestResponseFactory;
use App\Http\Controllers\Api\ApiController;
use App\Services\Core\Product\SuDaiZhiJiaProductService;
use Illuminate\Http\Request;

class LoanController extends ApiController
{
    /**
     * 基础信息 —— 推荐产品列表
     */
    public function products(Request $request)
    {
        $data = $request->all();
        $product_data = [
            'pageSize' => isset($data['pageSize']) ? $data['pageSize'] : 1,
            'pageNum' => isset($data['pageNum']) ? $data['pageNum'] : 10,
            'terminalType' => $data['terminalType'],
        ];

        $product_res = json_decode(SuDaiZhiJiaProductService::productCooperate($product_data),true);
        $data_list = isset($product_res['data']['list']) ? $product_res['data']['list'] : [];

        $res = [];
        if(!empty($data_list)) {
            foreach ($data_list as $data_key => &$data_val) {
                $data_url = [
                    'productId' => $data_val['platform_product_id'],
                ];
                $data_url_res = json_decode(SuDaiZhiJiaProductService::cooperateApplication($data_url), true);
                $res[$data_key]['product_logo'] = $data_val['product_logo'];
                $res[$data_key]['platform_product_name'] = $data_val['platform_product_name'];
                $res[$data_key]['product_introduct'] = $data_val['product_introduct'];
                $res[$data_key]['total_today_count'] = $data_val['total_today_count'];
                $res[$data_key]['url'] = isset($data_url_res['data']['product_h5_url']) ? $data_url_res['data']['product_h5_url'] : '';
            }
        }

        return RestResponseFactory::ok($res);
    }
}