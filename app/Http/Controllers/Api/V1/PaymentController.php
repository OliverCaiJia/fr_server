<?php

namespace App\Http\Controllers\Api\V1;

use App\Constants\UserReportConstant;
use App\Constants\UserVipConstant;
use App\Helpers\RestResponseFactory;
use App\Http\Controllers\Controller;
use App\Models\Chain\Order\VipOrder\DoVipOrderLogicHandler;
use App\Models\Factory\UserBankCardFactory;
use App\Models\Factory\UserIdentityFactory;
use App\Models\Factory\UserOrderFactory;
use App\Models\Factory\UserReportFactory;
use App\Models\Factory\UserVipFactory;
use App\Strategies\PaymentStrategy;
use App\Strategies\UserBankCardStrategy;
use App\Strategies\UserVipStrategy;
use Illuminate\Http\Request;

/**
 * 支付
 *
 * Class PaymentController
 * @package App\Http\Controllers\V1
 */
class PaymentController extends Controller
{
    /**
     * 确认页面,商品信息
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function confirm(Request $request)
    {
        $data = ["default_card" => [
            "user_bank_id" => 1150,
            "bank_id" => 4,
            "bank_name" => "中信银行",
            "bank_logo" => "",
            "account" => "6224****************5122",
            "last_num" => "5122",
            "card_type_name" => "储蓄卡",
            "card_last_status" => 1
        ],
            "price" => "19.90",
            "price_twice" =>"19.9",
            "business_name" => "jdt",
            "bug_name" => "信用报告",
            "expired_time" => "永久有效",
            "wechat" =>0,
            "alipay" =>0];
        return RestResponseFactory::ok($data);
    }

}