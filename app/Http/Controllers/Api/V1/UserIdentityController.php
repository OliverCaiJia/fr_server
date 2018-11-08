<?php
namespace App\Http\Controllers\Api\V1;

use App\Helpers\Http\HttpClient;
use App\Helpers\RestResponseFactory;
use App\Http\Controllers\Api\ApiController;
use App\Services\Core\Validator\ValidatorService;
use function Couchbase\defaultDecoder;

class UserIdentityController extends ApiController
{
    public function fetchFaceidToCardfrontInfo() {
        return RestResponseFactory::ok();
    }

    public function fetchFaceidToCardbackInfo() {
        return RestResponseFactory::ok();
    }

}