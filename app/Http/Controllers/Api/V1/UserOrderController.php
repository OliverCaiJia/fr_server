<?php

namespace App\Http\Controllers\Api\V1;

use App\Constants\UserOrderConstant;
use App\Helpers\Logger\SLogger;
use App\Helpers\RestResponseFactory;
use App\Helpers\RestUtils;
use App\Helpers\Utils;
use App\Http\Controllers\Api\ApiController;
use App\Models\Factory\Api\ExtraProductFactory;
use App\Models\Factory\Api\UserAuthFactory;
use App\Models\Factory\Api\UserOrderFactory;
use App\Models\Factory\FeeFactory;
use App\Strategies\OrderStrategy;
use App\Strategies\UserOrderStrategy;
use Illuminate\Http\Request;

class UserOrderController extends ApiController
{
    /**
     * 根据用户id获取订单列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $userId = $this->getUserId($request);
        $pageSize = $request->input('page_size');
        $pageIndex = $request->input('page_index');
        $orderTypeApply = UserOrderFactory::getOrderTypeByTypeNid('order_apply');
        if (empty($orderTypeApply)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1167), 1167);
        }
        $orderTypeExtra = UserOrderFactory::getOrderTypeByTypeNid('order_extra_service');
        if (empty($orderTypeApply)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1168), 1168);
        }
        $typeArr = [$orderTypeApply['id'], $orderTypeExtra['id']];
        $userOrder = UserOrderFactory::getUserOrderByUserIdPage(
            $userId,
            $typeArr,
            $pageSize,
            $pageIndex
        );
        $res = [];
        foreach ($userOrder['data'] as $uOrder) {
            $orderType = UserOrderFactory::getOrderTypeById($uOrder['order_type']);
            $res = UserOrderStrategy::getListByTypeNid($orderType['type_nid'], $orderType, $uOrder, $res);

        }
        return RestResponseFactory::ok($res);
    }

    /**
     * 报告fee
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function report()
    {
        $feeNid = 'CREDIT_COST_DEFAULT';
        $result = FeeFactory::getFeeByFeeNid($feeNid);
        $res = [];
        $res['name'] = $result['name'];
        $res['remark'] = $result['remark'];
        $res['price'] = $result['price'];
        $res['old_price'] = $result['old_price'];
        return RestResponseFactory::ok($res);
    }

    /**
     * 额外fee
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function extra(Request $request)
    {
        $feeNid = 'CREDIT_GROOM_DEFAULT';
        $result = FeeFactory::getFeeByFeeNid($feeNid);
        $res = [];
        $res['name'] = $result['name'];
        $res['remark'] = $result['remark'];
        $res['price'] = $result['price'];
        $res['old_price'] = $result['old_price'];
        return RestResponseFactory::ok($res);
    }

    /**
     * 根据订单编号和用户id获取订单详情
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function info(Request $request)
    {
        $userId = $this->getUserId($request);
        $orderNo = $request->input('order_no');
        $userOrder = UserOrderFactory::getUserOrderByOrderNo($orderNo);
        $orderType = UserOrderFactory::getOrderTypeById($userOrder['order_type']);

        $res = [];
        $res["order_type_nid"] = $orderType['type_nid'];

        //增值服务订单
        $res["extra"] = [];
        //报告类型订单
        $res["report"] = [];
        //贷款类型订单
        $res["loan"] = [];
        switch ($orderType['type_nid']) {
            case UserOrderConstant::ORDER_EXTRA_SERVICE :
                $res["extra"]["amount"] = $userOrder['amount'];
                $res["extra"]["status"] = $userOrder['status'];
                $res["extra"]["term"] = $userOrder['term'];
                $res["extra"]["stop_time"] = $userOrder['update_at'];
                $extraProduct = ExtraProductFactory::getExtraProduct();
                foreach ($extraProduct as $extraKey => $extraValue) {
                    $res["extra"]["borrow"][$extraKey] = [
                        'ext_prod_name' => isset($extraValue['ext_prod_name']) ? $extraValue['ext_prod_name'] : '',
                        'logo' => isset($extraValue['logo']) ? $extraValue['logo'] : '',
                        'url' => isset($extraValue['url']) ? $extraValue['url'] : '',
                        'money_limit' => isset($extraValue['money_limit']) ? $extraValue['money_limit'] : 0,
                    ];
                }
                $res["extra"]["confirm"] = [
                    [
                        'time' => date('Y-m-d H:i:s'),
                        'remark' => '提交申请',
                        'status' => 0
                    ],
                    [
                        'time' => date('Y-m-d H:i:s', strtotime("+2 second")),
                        'remark' => '风控审核中',
                        'status' => 1
                    ],
                    [
                        'time' => date('Y-m-d H:i:s', strtotime("+2 hour")),
                        'remark' => '一家或多家同时放款',
                        'status' => 0
                    ]
                ];
                $res["report"] = null;
                $res["loan"] = null;
                break;
            case UserOrderConstant::ORDER_REPORT_FOR_TYPE :
                $userOrder = UserOrderFactory::getUserOrderByUserIdAndOrderType($userId, $orderType['id']);
                $userAuth = UserAuthFactory::getUserById($userId);
                $res["report"]["amount"] = $userOrder['amount'];
                $res["report"]["order_no"] = $userOrder['order_no'];
                $res["report"]["status"] = $userOrder['status'];
                $res["report"]["create_at"] = $userOrder['create_at'];
                $res["report"]["url"] = 'http://uat.fruit.witlending.com/web/v1/user/report?token=' . $userAuth['access_token'];
                $res["extra"] = null;
                $res["loan"] = null;
                break;
            case UserOrderConstant::ORDER_APPLY :
                $spreadNid = UserOrderConstant::ONE_LOAN;
                $userOrder = UserOrderFactory::getUserOrderByUserIdOrderNoAndOrderType($userId, $orderNo, [$orderType['id']]);

                $res["loan"]["amount"] = $userOrder['amount'];
                $res["loan"]["term"] = $userOrder['term'];
                $res["loan"]["order_no"] = $userOrder['order_no'];
                $res["loan"]["status"] = $userOrder['status'];
                $res["loan"]["expired_time"] = date("Y-m-d", strtotime("+30 days", strtotime($userOrder['create_at'])));
                $loanTask = UserOrderFactory::getLoanTaskByUserIdAndSpreadNid($userId, $spreadNid);
                if (empty($loanTask)) {
                    return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1166), 1166);
                }
                $res["loan"]["push_status"] = $loanTask['status'];
                $res["report"] = null;
                $res["extra"] = null;
                break;
        }
        return RestResponseFactory::ok($res);
    }

    /**
     * 创建订单
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $this->getUserId($request);
        $orderTypeNid = $request->input('order_type_nid');
        $data['extra_type_nid'] = $request->input('extra_type_nid', '');
        $extra = UserOrderStrategy::getExtra($orderTypeNid);
        $data['order_no'] = UserOrderStrategy::createOrderNo($extra);
        $orderType = UserOrderFactory::getOrderTypeByTypeNid($orderTypeNid);
        $data['order_type'] = $orderType['id'];
        $data['order_expired'] = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $data['amount'] = $request->input('amount');
        $data['money'] = $request->input('money', 0) ?: 0;
        $data['term'] = $request->input('term', 0);
        $data['count'] = 1;
        $data['status'] = 0;
        $data['create_ip'] = Utils::ipAddress();
        $data['create_at'] = date('Y-m-d H:i:s', time());
        $data['update_ip'] = Utils::ipAddress();
        $data['update_at'] = date('Y-m-d H:i:s', time());
        $result = OrderStrategy::getDiffOrderTypeChainCreate($data);
        if (isset($result['error'])) {
            $result = UserOrderFactory::getUserOrderByUserIdAndOrderType($data['user_id'], $orderType['id']);
            $res = [];
            $res['order_no'] = $result['order_no'];
            $res['status'] = $result['status'];
            $res['order_type_nid'] = $orderTypeNid;
            $res['order_expired'] = $result['order_expired'];
            return RestResponseFactory::ok($res);
        }
        $res = [];
        $res['order_no'] = $result['order_no'];
        $res['status'] = $result['status'];
        $res['order_type_nid'] = $orderTypeNid;
        $res['order_expired'] = $result['order_expired'];
        return RestResponseFactory::ok($res);
    }

    /**
     * 查询订单状态
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStatus(Request $request)
    {
        $userId = $this->getUserId($request);
        $orderNo = $request->input('order_no');
        $userOrder = UserOrderFactory::getOrderByUserIdOrderNo($userId, $orderNo);
        $res['info']['status'] = $userOrder['status'];

        $res['info']['order_no'] = $userOrder['order_no'];
        $res['info']['status'] = $userOrder['status'];
//        $res['info']['order_type_nid'] = $orderTypeNid;
        $res['info']['order_expired'] = $userOrder['order_expired'];
        return RestResponseFactory::ok($res);
    }

    /**
     * 更新订单
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $this->getUserId($request);
        $data['order_no'] = $request->input('order_no');
        $orderTypeNid = $request->input('order_type_nid');
        $orderType = UserOrderFactory::getOrderTypeByTypeNid($orderTypeNid);
        $data['order_type'] = $orderType['id'];
        $data['payment_log_id'] = $request->input('payment_log_id', 0);
        $data['order_expired'] = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $data['amount'] = $request->input('amount');
        $data['term'] = $request->input('term', 0);
        $data['count'] = $request->input('count');
        $data['status'] = $request->input('status', 0);
        $data['create_ip'] = Utils::ipAddress();
        $data['create_at'] = date('Y-m-d H:i:s', time());
        $data['update_ip'] = Utils::ipAddress();
        $data['update_at'] = date('Y-m-d H:i:s', time());
        $data['platform_nid'] = $request->input('platform_nid', '');

        $order = OrderStrategy::getDiffOrderTypeChainForUpdate($data);
//        $res['order_no'] = $order['order_no'];
        if (isset($res['error'])) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1141), 1141);
        }
        return RestResponseFactory::ok($order);
    }


}