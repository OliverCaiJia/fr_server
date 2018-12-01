<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Models\Chain\QuickLogin\DoQuickLoginHandler;
use App\Models\Chain\Register\DoRegisterHandler;
use Illuminate\Http\Request;
use App\Helpers\RestResponseFactory;
use App\Models\Chain\Login\DoLoginHandler;
use App\Helpers\Generator\TokenGenerator;
use App\Helpers\RestUtils;
use App\Models\Factory\Api\UserAuthFactory;
use App\Events\V1\UserRegEvent;

class AuthController extends ApiController
{

    /**
     * 普通登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $data = $request->all();
        #调用普通登录责任链
        $login = new DoLoginHandler($data);
        $re = $login->handleRequest();
        if (isset($re['error']))
        {
            if ($re['code'] == 403403) {
                return RestResponseFactory::forbidden($re['error'], 403, $re['error']);
            }
            return RestResponseFactory::ok(RestUtils::getStdObj(), $re['error'], $re['code'], $re['error']);
        }
        //用户信息重组
        $re = [
            'user_id' => $re['id'],
            'mobile' => $re['mobile'],
            'status' => $re['status'],
            'access_token' => $re['access_token'],
        ];
        return RestResponseFactory::ok($re);
    }

    /**
     * 登出
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $userId = $this->getUserId($request);
        $token = TokenGenerator::generateToken();

        UserAuthFactory::updateUserTokenById($userId, $token);

        return RestResponseFactory::ok([], '退出成功');
    }

    /**
     * 快捷登录 手机号+验证码
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function quickLogin(Request $request)
    {
        $data = $request->all();
        $data['dev_type'] = $request->header('X-DevType') ? $request->header('X-DevType') : 0;
        $data['dev_model'] = $request->header('X-DevModel') ? $request->header('X-DevModel') : '';
        $data['dev_version'] = $request->header('X-DevVersion') ? $request->header('X-DevVersion') : '';
        #查库检查用户手机号是否存在
        $user = UserAuthFactory::getMobileAndIndent($data['mobile']);
        if ($user)
        {
            #如果用户激活则调用登录责任链
            $login = new DoQuickLoginHandler($data);
            $re = $login->handleRequest();
            if (isset($re['error']))
            {
                if ($re['code'] == 403403) {
                    return RestResponseFactory::forbidden($re['error'], 403, $re['error']);
                }
                return RestResponseFactory::ok(RestUtils::getStdObj(), $re['error'], $re['code'], $re['error']);
            }
            $re = [
                'user_id' => $re['id'],
                'mobile' => $re['mobile'],
                'status' => $re['status'],
                'access_token' => $re['access_token'],
            ];
            return RestResponseFactory::ok($re);
        }
        else
        {
            #如果用户未激活调用注册责任链
            $register = new DoRegisterHandler($data);
            $re = $register->handleRequest();
            if (isset($re['error']))
            {
                return RestResponseFactory::ok(RestUtils::getStdObj(), $re['error'], $re['code'], $re['error']);
            }
        }
        $re = [
            'user_id' => $re['id'],
            'mobile' => $re['mobile'],
            'status' => $re['status'],
            'access_token' => $re['access_token'],
        ];
        return RestResponseFactory::ok($re);
    }

}
