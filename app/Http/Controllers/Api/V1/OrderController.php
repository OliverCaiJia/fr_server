<?php
namespace App\Http\Controllers\Api\V1;

use App\Helpers\Http\HttpClient;
use App\Helpers\RestResponseFactory;
use App\Http\Controllers\Api\ApiController;
use App\Services\Core\Validator\ValidatorService;
use function Couchbase\defaultDecoder;

class OrderController extends ApiController
{
    public function list() {

        $res = [
            ["id"=> 3,
        "user_id"=> 1581,
        "serial_num"=> "",
        "pay_type"=> 2,
        "step"=> 1,
        "end_time"=> "2017-12-25 11:56:39",
        "front_serial_num"=> "",
        "start_time"=> "2017-11-25",
        "username"=> "夏杉杉",
        "idcard"=> "372928****************8747",
        "step_sign"=> 1]
        ];
        return RestResponseFactory::ok($res);
    }

    public function info() {
        return RestResponseFactory::ok();
    }

    public function create() {
        $res = [
            "payurl"=> "http://www.xxx.com",
        "fcallbackurl"=>"http://uat.api.sudaizhijia.com/v1/users/payment/callback/yibao/syncallbacks?type=user_report"
        ];
        return RestResponseFactory::ok($res);
    }

    public function status() {
        $res = [
            ["report_status"=> 0,
    "vip_status"=> 1]
        ];
        return RestResponseFactory::ok($res);
    }
}