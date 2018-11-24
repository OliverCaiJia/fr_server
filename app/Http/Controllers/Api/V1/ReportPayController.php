<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\RestResponseFactory;
use App\Helpers\RestUtils;
use App\Http\Controllers\Api\ApiController;
use App\Models\Chain\Order\PayOrder\UserOrder\DoPayOrderHandler;
use App\Models\Factory\Api\UserAuthFactory;
use App\Models\Factory\Api\UserBankcardFactory;
use App\Models\Factory\Api\UserOrderFactory;
use App\Models\Factory\Api\UserRealnameFactory;
use App\Models\Factory\Api\UserReportFactory;
use App\Services\Core\Payment\YiBao\YiBaoService;
use App\Services\Core\Validator\Scorpion\Mozhang\MozhangService;
use App\Strategies\OrderStrategy;
use Illuminate\Http\Request;

class ReportPayController extends ApiController
{

    public function doReportPay(Request $request)
    {
        $userId = $this->getUserId($request);
        $orderId = $request->input('order_id');
        $userOrder = UserOrderFactory::getUserOrderByUserIdAndOrderId($userId, $orderId);
        if (empty($userOrder)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), '未找到该订单', 12345, '未找到该订单');
        }
        $orderAmount = isset($userOrder['amount']) ? $userOrder['amount'] : 0;

        $orderType = UserOrderFactory::getOrderTypeById($userOrder['order_type']);

        $goodsArr = [];
        $goodsArr['goodsName'] = $orderType['name'];
        $goodsArr['remark'] = $orderType['remark'];
        $goodsParamExt = json_encode($goodsArr);

        $userRealName = UserRealnameFactory::fetchUserRealname($userId);
        if (empty($userRealName)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), '未找到该用户', 12348, '未找到该用户');
        }
        $paymentArr = [];
        $paymentArr['cardName'] = $userRealName['real_name'];
        $paymentArr['bankCardNo'] = $request->input('bank_card_no');
        $userBankcard = UserBankcardFactory::getUserBankCardByCardNoAndUserId($paymentArr['bankCardNo'], $userId);
        if (empty($userBankcard)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), '未找到该银行卡信息', 12350, '未找到该银行卡信息');
        }
        $paymentArr['idCardNo'] = $userBankcard['idcard'];
        $paymentParamExt = json_encode($paymentArr);
        $userNo = $userBankcard['bank_card_mobile'];

        $data['orderId'] = $orderId;
        $data['orderAmount'] = $orderAmount;
        $data['goodsParamExt'] = $goodsParamExt;
        $data['paymentParamExt'] = $paymentParamExt;
        $data['userNo'] = $userNo;
        $res = YiBaoService::send($data);
        return $res;
    }
}