<?php
namespace App\Http\Controllers\Api\V1;

use App\Helpers\RestResponseFactory;
use App\Helpers\Utils;
use App\Http\Controllers\Api\ApiController;
use App\Models\Factory\Api\UserOrderFactory;
use App\Models\Orm\UserApplyLog;
use App\Services\Core\Product\SuDaiZhiJiaProductService;
use App\Strategies\UserOrderStrategy;
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

    /**
     * 重新借款免费订单创建
     * @param Request $request
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function reapply(Request $request){
        $data = $request->all();
        $userId = $this->getUserId($request);
        $status = [1];//订单处理完成
        $userOrder = UserOrderFactory::getUserOrderByUserIdOrderNoAndStatus($userId, $data['order_no'], $status);
        if (!empty($userOrder)){
            return RestResponseFactory::ok($userOrder);
        }
        $applyUser = [];
        $applyUser['user_id']=$userId;
        $orderTypeNid ='order_apply';
        $extra = UserOrderStrategy::getExtra($orderTypeNid);
        $applyUser['order_no'] = UserOrderStrategy::createOrderNo($extra);
        $orderType = UserOrderFactory::getOrderTypeByTypeNid($orderTypeNid);
        $applyUser['order_type'] = $orderType['id'];
        $applyUser['p_order_id'] = 0;//默认无父级
        $applyUser['order_expired'] = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $applyUser['amount'] = $request->input('amount');
        $applyUser['money'] = $request->input('money', 0) ?: 0;
        $applyUser['term'] = $request->input('term', 0);
        $applyUser['count'] = 1;
        $applyUser['status'] = 0;
        $applyUser['create_ip'] = Utils::ipAddress();
        $applyUser['create_at'] = date('Y-m-d H:i:s', time());
        $applyUser['update_ip'] = Utils::ipAddress();
        $applyUser['update_at'] = date('Y-m-d H:i:s', time());

        $result = UserOrderFactory::createOrder($applyUser);

        if ($result) {
            return RestResponseFactory::ok($result);
        }
        return false;
    }
}