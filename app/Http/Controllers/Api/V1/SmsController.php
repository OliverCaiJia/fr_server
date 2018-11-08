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
     * @return mixed
     * @throws \Exception
     * 忘记密码
     */
    public function forgetPwd(Request $request)
    {
        return RestResponseFactory::ok();
    }

    /**
     * 手机号短信验证码
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function phone(Request $request)
    {
        $data['mobile'] = $request->input('mobile');

        //验证短信1分钟之内不能重复发送
        $not_exprise = SmsFactory::checkCodeExistenceTime($data['mobile'], 'phone');
        if (!$not_exprise)
        {
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1201), 1201);
        }

        $code = mt_rand(1000, 9999);
        $data['message'] = "验证码：{$code}，请勿泄露。关注官方微信“速贷之家官微”";
        $data['code'] = $code;
        $re = SmsService::i()->to($data);
        $random = [];
        $random['sign'] = TokenGenerator::generateToken();
        SmsFactory::putSmsCodeToCache('mobile_code_' . $data['mobile'], $code);
        SmsFactory::putSmsCodeToCache('mobile_random_' . $data['mobile'], $random);
        if (!$re)
        {
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1205), 1205);
        }
        return RestResponseFactory::ok($random);
    }

    /**
     * 修改手机号 —— 短信验证码
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePhone(Request $request)
    {
        $data['mobile'] = $request->input('mobile');

        //验证短信1分钟之内不能重复发送
        $not_exprise = SmsFactory::checkCodeExistenceTime($data['mobile'], 'updatephone');
        if (!$not_exprise)
        {
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1201), 1201);
        }

        //验证手机号是否已存在
        $userinfo = UserFactory::getIdByMobile($data['mobile']);
        if ($userinfo)
        {
            //手机号已注册
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1115), 1115);
        }

        $code = mt_rand(1000, 9999);
        $data['message'] = "验证码：{$code}，请勿泄露。关注官方微信“速贷之家官微”";
        $data['code'] = $code;
        $re = SmsService::i()->to($data);
        $random = [];
        $random['sign'] = TokenGenerator::generateToken();
        SmsFactory::putSmsCodeToCache('update_mobile_code_' . $data['mobile'], $code);
        SmsFactory::putSmsCodeToCache('update_mobile_random_' . $data['mobile'], $random);
        if (!$re)
        {
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1205), 1205);
        }
        return RestResponseFactory::ok($random);
    }

    /**
     * 落地页根据手机号是否注册进行不同操作
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function check(Request $request)
    {
        $data['mobile'] = $request->input('mobile');

        //验证手机号是否已存在
        $userinfo = UserFactory::getIdByMobileAndStatus($data['mobile']);
        if ($userinfo)
        {
            //手机号已注册
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1115), 1115);
        }
        else
        {
            //手机号未注册
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1124), 1124);
        }
    }

}
