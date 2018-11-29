<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Logger\SLogger;
use App\Helpers\RestResponseFactory;
use App\Helpers\RestUtils;
use App\Http\Controllers\Api\ApiController;
use App\Models\Factory\Api\UserBankcardFactory;
use App\Models\Factory\Api\UserOrderFactory;
use App\Models\Factory\Api\UserRealnameFactory;
use App\Services\Core\Payment\YiBao\YiBaoService;
use App\Strategies\UserOrderStrategy;
use Illuminate\Http\Request;

class ReportPayController extends ApiController
{
    /**
     * 调用易宝支付返回支付页面
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function doReportPay(Request $request)
    {
        $userId = $this->getUserId($request);
        $orderId = $request->input('order_id');
//        $userOrder = UserOrderFactory::getUserOrderByUserIdAndOrderNo($userId, $orderId);
        $status = [0];
        $userOrder = UserOrderFactory::getUserOrderByUserIdOrderNoAndStatus($userId, $orderId, $status);

        if (empty($userOrder)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), '未找到该订单', 12345, '未找到该订单');
        }
        $orderType = UserOrderFactory::getOrderTypeNidByTypeId($userOrder['order_type']);
        $extra = UserOrderStrategy::getExtra($orderType['type_nid']);
        $data['order_no'] = UserOrderStrategy::createOrderNo($extra);
        $userOrderUpdate = UserOrderFactory::updateOrderById($userOrder['id'], $data);
        if (!$userOrderUpdate){
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1141), 1141);
        }
//        $orderAmount = $userOrder['amount'];

        $orderType = UserOrderFactory::getOrderTypeById($userOrder['order_type']);
        $goodsName = $orderType['name'];
        $goodsDesc = $orderType['remark'];
        $goodsParamExt = '{"goodsName":"' . $goodsName . '","goodsDesc":"' . $goodsDesc . '"}';

        $userRealName = UserRealnameFactory::fetchUserRealname($userId);
        if (empty($userRealName)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), '未找到该用户', 12348, '未找到该用户');
        }
        $paymentArr = [];
        $cardName = $userRealName['real_name'];
        $paymentArr['bankCardNo'] = $request->input('bank_card_no');
        $bankCardNo = $request->input('bank_card_no');
        $userBankcard = UserBankcardFactory::getUserBankCardByCardNoAndUserId($paymentArr['bankCardNo'], $userId);
        if (empty($userBankcard)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), '未找到该银行卡信息', 12350, '未找到该银行卡信息');
        }
        $paymentArr['idCardNo'] = $userBankcard['idcard'];
        $idCardNo = $userBankcard['idcard'];
        $paymentParamExt = '{"bankCardNo":"' . $bankCardNo . '","idCardNo":"' . $idCardNo . '","cardName":"' . $cardName . '"}';
        $userNo = $userBankcard['bank_card_mobile'];

        $data['orderId'] = $orderId;
        $data['orderAmount'] = $userOrder['amount'];
        $data['goodsParamExt'] = $goodsParamExt;
        $data['paymentParamExt'] = $paymentParamExt;
        $data['userNo'] = $userNo;
        SLogger::getStream()->error(json_encode($data));
        $res = [];
        $result = YiBaoService::send($data);

        if ($result['code'] != 200) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1155), 1155);
        }
        $res['url'] = $result['data']['url'];
        return RestResponseFactory::ok($res);
    }
}