<?php

namespace App\Http\Controllers\Api\V1;

use App\Constants\UserOrderConstant;
use App\Helpers\RestResponseFactory;
use App\Helpers\RestUtils;
use App\Helpers\Utils;
use App\Http\Controllers\Api\ApiController;
use App\Models\Factory\Api\PlatformFactory;
use App\Models\Factory\Api\UserOrderFactory;
use App\Models\Factory\FeeFactory;
use App\Models\Orm\Platform;
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
//        $userOrder = UserOrderFactory::getOrderAndTypeLogoByUserId($userId);

        $userOrder = UserOrderFactory::getUserOrderByUserIdAndStatus($userId, UserOrderConstant::ORDER_SUCCESS_STATUS);
        $res = [];
        foreach ($userOrder as $uOrder) {
            $orderType = UserOrderFactory::getOrderTypeNidByTypeId($uOrder['order_type']);
            $res[] = [
                "order_no" => $uOrder['order_no'],
                "order_type_nid" => $orderType['type_nid'],
                "create_at" => $uOrder['create_at'],
                "amount" => $uOrder['amount'],
                "term" => $uOrder['term'],
                "logo_url" => $orderType['logo_url'],
                "status" => $uOrder['status']
            ];
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

        $userOrderPlatfrom = UserOrderFactory::getOrderPlatformByUserIdAndOrderNo($userId, $orderNo);

        $res = [];
        $res["order_type_nid"] = $orderType['type_nid'];

        //增值服务订单
        $res["extra"] = [];
        //报告类型订单
        $res["report"] = [];
        //贷款类型订单
        $res["loan"] = [];
        switch ($orderType['type_nid']) {
            case 'order_extra_service' :
//                $res["extra"]["extra_status"] = 1;
                foreach ($userOrderPlatfrom as $platformKey => $platformValue) {
                    $platform = PlatformFactory::getPlatformById($platformValue['platform_id']);
                    $res["extra"][$platformKey]["amount"] = $platformValue['amount'];
                    $res["extra"][$platformKey]["status"] = $platformValue['status'];
                    $res["extra"][$platformKey]["stop_time"] = $platformValue['update_at'];// 入中间表的时间
                    $res["extra"][$platformKey]["borrow"][] = [
                        'platform_name' => isset($platform['platform_name']) ? $platform['platform_name'] : '',
                        'logo' => isset($platform['logo']) ? $platform['logo'] : '',
                        'url' => isset($platform['url']) ? $platform['url'] : ''
                    ];
                }
                $res["extra"]["confirm"] = [
                    [
                        'time' => date('Y-m-d H:i:s'),
                        'remark' => '提交申请',
                        'extra_status' => 0
                    ],
                    [
                        'time' => date('Y-m-d H:i:s', strtotime("+1 hour")),
                        'remark' => '风控审核中',
                        'status' => 1
                    ],
                    [
                        'time' => date('Y-m-d H:i:s', strtotime("+2 hour")),
                        'remark' => '一家或多家同时放款',
                        'status' => 0
                    ]
                ];
                break;
            case 'order_report' :
                $userOrder= UserOrderFactory::getUserOrderByUserIdAndOrderType($userId, $orderType['id']);
                $res["report"]["amount"] = $userOrder['amount'];
                $res["report"]["order_no"] = $userOrder['order_no'];
                $res["report"]["status"] = $userOrder['status'];
                $res["report"]["create_at"] = $userOrder['create_at'];
                //todo::
                $res["report"]["url"] = '';
                break;
            case 'order_apply':
                $spreadNid = 'oneLoan';
                $userOrder= UserOrderFactory::getUserOrderByUserIdAndOrderType($userId, $orderType['id']);
                $res["loan"]["amount"] = $userOrder['amount'];
                $res["loan"]["order_no"] = $userOrder['order_no'];
                $res["loan"]["status"] = $userOrder['status'];
                $res["loan"]["create_at"] = $userOrder['create_at'];
                $loanTask = UserOrderFactory::getLoanTaskByUserIdAndSpreadNid($userId, $spreadNid);
                $res["loan"]["push_status"] = $loanTask['status'];
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
        $extra = UserOrderStrategy::getExtra($orderTypeNid);
        $data['order_no'] = UserOrderStrategy::createOrderNo($extra);
        $orderType = UserOrderFactory::getOrderTypeByTypeNid($orderTypeNid);
        $data['order_type'] = $orderType['id'];
        $data['order_expired'] = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $data['amount'] = $request->input('amount');
        $data['term'] = $request->input('term', 0);
        $data['count'] = 1;
        $data['status'] = 0;
        $data['create_ip'] = Utils::ipAddress();
        $data['create_at'] = date('Y-m-d H:i:s', time());
        $data['update_ip'] = Utils::ipAddress();
        $data['update_at'] = date('Y-m-d H:i:s', time());
        $data['platform_nid'] = $request->input('platform_nid', '');

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