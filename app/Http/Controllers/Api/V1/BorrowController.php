<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Http\HttpClient;
use App\Helpers\RestResponseFactory;
use App\Http\Controllers\Api\ApiController;
use App\Services\Core\Validator\ValidatorService;
use function Couchbase\defaultDecoder;

class BorrowController extends ApiController
{
    public function home()
    {
        $res = [
            "id" => 1760,
            "user_id" => 1288,
            "platform_product_id" => 286,
            "platform_id" => 126,
            "is_urge" => 0,
            "is_comment" => 0,
            "created_at" => "2018-01-13申请",
            "created_time" => "2018/01/13",
            "platform_product_name" => "未跑批夸两句",
            "product_logo" => "http://image.sudaizhijia.com/test/20171225/platform/20171225133701-785.jpg",
            "loan_money" => "5万-1500万元",
            "period_time" => "24-60月",
            "service_mobile" => ""
        ];
        return RestResponseFactory::ok($res);
    }

    public function default()
    {
        return RestResponseFactory::ok();
    }
}