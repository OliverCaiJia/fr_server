<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Models\Chain\Order\PayOrder\UserOrder\DoPayOrderHandler;
use App\Models\Factory\Api\UserAuthFactory;
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
        $order = [];
        $chain = new DoPayOrderHandler($order);

        $result = $chain->handleRequest();
        $result = YiBaoService::send();
    }
}