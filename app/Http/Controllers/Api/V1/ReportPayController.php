<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Logger\SLogger;
use App\Helpers\RestResponseFactory;
use App\Helpers\RestUtils;
use App\Helpers\Utils;
use App\Http\Controllers\Api\ApiController;
use App\Models\Factory\Api\UserBankcardFactory;
use App\Models\Factory\Api\UserOrderFactory;
use App\Models\Factory\Api\UserRealnameFactory;
use App\Models\Orm\PaymentLog;
use App\Services\Core\Payment\PaymentService;
use App\Strategies\PaymentStrategy;
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
        $orderNo = $request->input('order_no');
        $bankCardNo = $request->input('bank_card_no');

        $status = [0];
        $userOrder = UserOrderFactory::getUserOrderByUserIdOrderNoAndStatus($userId, $orderNo, $status);
        if (empty($userOrder)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), '未找到该订单', 12345, '未找到该订单');
        }
        $orderType = UserOrderFactory::getOrderTypeNidByTypeId($userOrder['order_type']);
        $extra = UserOrderStrategy::getExtra($orderType['type_nid']);
        $dataUpdate = [];
        $dataUpdate['order_no'] = UserOrderStrategy::createOrderNo($extra);
        $userOrderUpdate = UserOrderFactory::updateOrderById($userOrder['id'], $dataUpdate);
//
        if (!$userOrderUpdate) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1141), 1141);
        }
        $userRealName = UserRealnameFactory::fetchUserRealname($userId);
        if (empty($userRealName)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), '未找到该用户', 12348, '未找到该用户');
        }
        $userBankcard = UserBankcardFactory::getUserBankCardByCardNoAndUserId($bankCardNo, $userId);
        if (empty($userBankcard)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), '未找到该银行卡信息', 12350, '未找到该银行卡信息');
        }

        $data = [];
        $data['order_id'] = $dataUpdate['order_no'];
        $data['amount'] = (int)($userOrder['amount'] * 100);
        $data['productname'] = $orderType['name'];
        $data['productdesc'] = $orderType['remark'];
        $data['mobile'] = $userBankcard['bank_card_mobile'];
        $data['cardno'] = $request->input('bank_card_no');
        $data['idcard'] = $userBankcard['idcard'];
        $data['owner'] = $userRealName['real_name'];

        $yibaoParams = PaymentStrategy::orderYibaoParams($data);
        //todo::先写死金额，测试
        SLogger::getStream()->info(__CLASS__);
        SLogger::getStream()->info(json_encode($yibaoParams));
        SLogger::getStream()->info(__CLASS__);
        $res = [];
        $result = PaymentService::i()->order($yibaoParams);
        if (empty($result)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1155), 1155);
        }
        $cardUpdate['card_no'] = $bankCardNo;
        $cardUpdate['update_at'] = date('Y-m-d H:i:s');
        $userCardUpdate = UserOrderFactory::updateOrderById($userOrder['id'], $cardUpdate);
        if (!$userCardUpdate) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1141), 1141);
        }
        //记录payment_log

        $paymentData['user_id'] = $userId;
        $paymentData['payment_id'] = 1;
        $paymentData['payment_order_no'] = $dataUpdate['order_no'];
        $paymentData['payment_type'] = 1;
        $paymentData['order_expired'] = $userOrder['order_expired'];
        $paymentData['terminal_nid'] = $request->header('X-DevType');
        $paymentData['bankcard_id'] = $bankCardNo;
        $paymentData['lastno'] = substr($data['cardno'], -4);
        $paymentData['amount'] = $userOrder['amount'];
        $paymentData['status'] = $userOrder['status'];
        $paymentData['request_data'] = json_encode($data);
        $paymentData['response_data'] = '{}';
        $paymentData['create_ip'] = Utils::ipAddress();
        $paymentData['create_at'] = date('Y-m-d H:i:s');
        PaymentLog::insert($paymentData);

        $res['url'] = $result['payurl'];
        $res['order_no'] = $result['orderid'];
        return RestResponseFactory::ok($res);
    }
}