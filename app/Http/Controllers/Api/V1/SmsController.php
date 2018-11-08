<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Generator\TokenGenerator;
use App\Helpers\RestResponseFactory;
use App\Helpers\RestUtils;
use App\Http\Controllers\Controller;
use App\Models\Chain\Sms\Register\DoSmsRegisterHandler;
use App\Models\Factory\SmsFactory;
use App\Models\Factory\UserFactory;
use App\Services\Core\Sms\SmsService;
use Illuminate\Http\Request;
use DB;
use Log;

class SmsController extends Controller
{

    /**
     * 注册---短信验证码
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        return RestResponseFactory::ok();
    }

    /**
     * 修改密码 —— 短信验证码
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function password(Request $request)
    {
        return RestResponseFactory::ok();
    }

    /**
     * @param Request $request
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 忘记密码 —— 短信验证码
     */
    public function forgetPwd(Request $request)
    {
        return RestResponseFactory::ok();
    }
}
