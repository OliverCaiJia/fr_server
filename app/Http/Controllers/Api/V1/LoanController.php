<?php

namespace App\Http\Controllers\Api\V1;

use App\Constants\UserOrderConstant;
use App\Helpers\RestResponseFactory;
use App\Helpers\Utils;
use App\Http\Controllers\Api\ApiController;
use App\Models\Factory\Api\UserBorrowLogFactory;
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

        $product_res = json_decode(SuDaiZhiJiaProductService::productCooperate($product_data), true);
        $data_list = isset($product_res['data']['list']) ? $product_res['data']['list'] : [];

        $res = [];
        if (!empty($data_list)) {
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
    public function productUrl(Request $request)
    {
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
        if (!$resultLog) {
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
    public function reapply(Request $request)
    {
        $userId = $this->getUserId($request);
        $orderTypeApply = UserOrderFactory::getOrderTypeByTypeNid(UserOrderConstant::ORDER_APPLY);
        if (empty($orderTypeApply)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1167), 1167);
        }
        $normalStatus = [1];
        $userOrderNormal = UserOrderFactory::getUserOrderByUserIdAndStatusAndTypeId($userId, $normalStatus, $orderTypeApply['id']);
        $status = [2, 3, 4];//订单过期等非正常状态
        $userOrder = UserOrderFactory::getUserOrderByUserIdAndStatusAndTypeIdDesc($userId, $status, $orderTypeApply['id']);
        $applyUser = [];
        $applyUser['user_id'] = $userId;
        $orderTypeNid = UserOrderConstant::ORDER_APPLY;
        $extra = UserOrderStrategy::getExtra($orderTypeNid);
        $applyUser['order_no'] = UserOrderStrategy::createOrderNo($extra);
        $orderType = UserOrderFactory::getOrderTypeByTypeNid($orderTypeNid);
        $applyUser['order_type'] = $orderType['id'];
        $applyUser['p_order_id'] = 0;//默认无父级
        $applyUser['order_expired'] = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $applyUser['count'] = 1;
        $applyUser['status'] = 1;//默认订单处理完成
        $applyUser['create_ip'] = Utils::ipAddress();
        $applyUser['create_at'] = date('Y-m-d H:i:s', time());
        $applyUser['update_ip'] = Utils::ipAddress();
        $applyUser['update_at'] = date('Y-m-d H:i:s', time());
        if (empty($userOrderNormal) && empty($userOrder)) {
            //create-----borrow_log
            $userBorrowLog = UserBorrowLogFactory::getBorrowLogDesc($userId);
            $applyUser['amount'] = 0;
            $applyUser['money'] = isset($userBorrowLog['money']) ? $userBorrowLog['money'] : 0;
            $applyUser['term'] = isset($userBorrowLog['term']) ? $userBorrowLog['term'] : 0;
            $result = UserOrderFactory::createOrder($applyUser);
            if (empty($result)) {
                return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1136), 1136);
            }
            return RestResponseFactory::ok($result);
        }
        if (empty($userOrderNormal) && !empty($userOrder)) {
            //create-----
            $applyUser['amount'] = $userOrder['amount'];
            $applyUser['money'] = $userOrder['money'];
            $applyUser['term'] = $userOrder['term'];
            $result = UserOrderFactory::createOrder($applyUser);
            if (empty($result)) {
                return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1136), 1136);
            }
            return RestResponseFactory::ok($result);
        }
        if (!empty($userOrderNormal)) {
            //非空返回
            return RestResponseFactory::ok($userOrderNormal);
        }
    }

    /**
     * 整理数据返回
     * @param $userOrder
     * @return \Illuminate\Http\JsonResponse
     */
    public function arrangeData($userOrder)
    {
        $res = [];
        $orderType = UserOrderFactory::getOrderTypeNidByTypeId($userOrder['order_type']);
        $res = [
            "order_no" => $userOrder['order_no'],
            "order_type_nid" => UserOrderConstant::ORDER_APPLY,
            "amount" => $userOrder['money'],//前端不改字段，用money， ××（金额）/××（天）
            "term" => $userOrder['term'],
            "create_at" => $userOrder['create_at'],
            "logo_url" => $orderType['logo_url'],
            "status" => $userOrder['status']
        ];
        return RestResponseFactory::ok($res);
    }
}