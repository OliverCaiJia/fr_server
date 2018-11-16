<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\RestResponseFactory;
use App\Helpers\RestUtils;
use App\Http\Controllers\Api\ApiController;
use App\Models\Chain\Sms\Register\DoSmsRegisterHandler;
use App\Models\Factory\SmsFactory;
use Illuminate\Http\Request;

class SmsController extends ApiController
{

    /**
     * 注册---短信验证码
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        #获取传过来的手机号
        $data = $request->all();

        //验证短信1分钟之内不能重复发送
        $not_exprise = SmsFactory::checkCodeExistenceTime($data['mobile'], 'register');
        if (!$not_exprise)
        {
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1201), 1201);
        }

        //短信注册链
        $smsRegister = new DoSmsRegisterHandler($data);
        $re = $smsRegister->handleRequest();

        if (isset($re['error'])) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), $re['error'], $re['code'], $re['error']);
        }
        return RestResponseFactory::ok($re);
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
