<?php

namespace App\Http\Controllers\Api\V1;

use App\Constants\UserConstant;
use App\Helpers\RestUtils;
use App\Helpers\Utils;
use App\Models\Factory\AccountFactory;
use App\Models\Factory\AuthFactory;
use App\Models\Factory\CreditFactory;
use App\Models\Factory\PhoneFactory;
use App\Models\Factory\UserFactory;
use App\Models\Factory\UserSignFactory;
use App\Models\Orm\UserContacts;
use App\Strategies\SmsStrategy;
use App\Strategies\UserStrategy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\RestResponseFactory;
use App\Models\Chain\Club\Password\DoPasswordHandler;

class UserController extends Controller
{
    /**
     *设置密码
     * @param Request $request
     */
    public function updatePwd(Request $request)
    {
        $data = ['need_relogin' => true];
        return RestResponseFactory::ok($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 修改用户头像
     */
    public function uploadPhoto(Request $request)
    {
        return RestResponseFactory::ok();
    }

}