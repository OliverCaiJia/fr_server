<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Logger\SLogger;
use App\Helpers\RestResponseFactory;
use App\Helpers\RestUtils;
use App\Helpers\Utils;
use App\Http\Controllers\Api\ApiController;
use App\Models\Factory\Api\UserBankcardFactory;
use App\Models\Factory\Api\UserinfoFactory;
use App\Models\Factory\Api\UserOrderFactory;
use App\Models\Factory\Api\UserRealnameFactory;
use App\Models\Orm\PaymentLog;
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
        $orderNo = $request->input('order_no');
//        $userOrder = UserOrderFactory::getUserOrderByUserIdAndOrderNo($userId, $orderId);

        $status = [0];
        $userOrder = UserOrderFactory::getUserOrderByUserIdOrderNoAndStatus($userId, $orderNo, $status);
        if (empty($userOrder)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), '未找到该订单', 12345, '未找到该订单');
        }
        $orderType = UserOrderFactory::getOrderTypeNidByTypeId($userOrder['order_type']);
        $extra = UserOrderStrategy::getExtra($orderType['type_nid']);
        $data['order_no'] = UserOrderStrategy::createOrderNo($extra);
        $userOrderUpdate = UserOrderFactory::updateOrderById($userOrder['id'], $data);

        if (!$userOrderUpdate) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1141), 1141);
        }
        $orderAmount = $userOrder['amount'];

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

        $data['orderId'] = $data['order_no'];
        //todo::先写死金额，测试
//        $data['orderAmount'] = $orderAmount;
        $data['orderAmount'] = 0.01;
        $data['goodsParamExt'] = $goodsParamExt;
        $data['paymentParamExt'] = $paymentParamExt;
        $data['userNo'] = $userNo;
        SLogger::getStream()->error('22222222222222222');
        SLogger::getStream()->error(json_encode($data));
        SLogger::getStream()->error('33333333333333333');
        $res = [];
        $result = YiBaoService::send($data);

        if ($result['code'] != 200) {
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
        $paymentData['payment_order_no'] = $data['order_no'];
        $paymentData['payment_type'] = 1;
        $paymentData['order_expired'] = $userOrder['order_expired'];
        $paymentData['terminal_nid'] = $request->header('X-DevType');
        $paymentData['bankcard_id'] = $paymentArr['bankCardNo'];
        $paymentData['lastno'] = substr($bankCardNo,-4);
        $paymentData['amount'] = $userOrder['amount'];
        $paymentData['status'] = $userOrder['status'];
        $paymentData['request_data'] = json_encode($data);
        $paymentData['response_data'] = '{}';
        $paymentData['create_ip'] = Utils::ipAddress();
        $paymentData['create_at'] = date('Y-m-d H:i:s');
        PaymentLog::insert($paymentData);

        $res['url'] = $result['data']['url'];
        $res['order_no'] = $data['order_no'];
        return RestResponseFactory::ok($res);
    }
}