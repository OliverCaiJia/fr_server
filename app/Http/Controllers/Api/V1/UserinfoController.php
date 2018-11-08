<?php
namespace App\Http\Controllers\Api\V1;

use App\Helpers\Http\HttpClient;
use App\Helpers\RestResponseFactory;
use App\Http\Controllers\Api\ApiController;
use App\Services\Core\Validator\ValidatorService;
use function Couchbase\defaultDecoder;

class UserInfoController extends ApiController
{
    //face++
    public function fetchUserInfo() {
        $res = [];
        return RestResponseFactory::ok($res);
    }
}