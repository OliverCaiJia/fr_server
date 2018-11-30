<?php
namespace App\Http\Controllers\Api\V1;

use App\Helpers\RestResponseFactory;
use App\Http\Controllers\Api\ApiController;
use App\Models\Orm\UserApplyLog;
use App\Services\Core\Product\SuDaiZhiJiaProductService;
use Illuminate\Http\Request;
use App\Helpers\RestUtils;

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
                $res[$data_key]['platform_product_id'] = $data_val['platform_product_id'];
                $res[$data_key]['product_logo'] = $data_val['product_logo'];
                $res[$data_key]['platform_product_name'] = $data_val['platform_product_name'];
                $res[$data_key]['product_introduct'] = $data_val['product_introduct'];
                $res[$data_key]['total_today_count'] = $data_val['total_today_count'];
                $res[$data_key]['quota'] = $data_val['quota'];
            }
        }

        return RestResponseFactory::ok($res);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 获取产品url
     */
    public function productUrl(Request $request){
        $data = $request->all();
        $data_url = [
            'productId' => $data['product_id'],
        ];
        $res = [];
        //查询产品url
        $data_url_res = json_decode(SuDaiZhiJiaProductService::cooperateApplication($data_url), true);
        $product_url = isset($data_url_res['data']['product_h5_url']) ? $data_url_res['data']['product_h5_url'] : '';

        //记录apply_log
        $data_apply['user_id'] = $this->getUserId($request);
        $data_apply['product_id'] = $data['product_id'];
        $data_apply['product_url'] = $product_url ? $product_url : '';
        $data_apply['create_at'] = date('Y-m-d H:i:s');
        $data_apply['update_at'] = date('Y-m-d H:i:s');
        $resultLog = UserApplyLog::insert($data_apply);
        if(!$resultLog){
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1005), 1005);
        }

        $res['product_url'] = $product_url;

        return RestResponseFactory::ok($res);

    }
}