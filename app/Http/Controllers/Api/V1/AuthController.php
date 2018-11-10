<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\Helpers\RestResponseFactory;
use App\Models\Chain\Login\DoLoginHandler;
use App\Helpers\Generator\TokenGenerator;
use App\Helpers\RestUtils;
use App\Models\Factory\Api\UserAuthFactory;


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
     * 验证码快捷登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function quickLogin(Request $request)
    {
        return RestResponseFactory::ok();
    }

    /**
     * 登出
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $userId = $request->user_id;
        $token = TokenGenerator::generateToken();

        UserAuthFactory::updateUserTokenById($userId, $token);

        return RestResponseFactory::ok([], '退出成功');
    }

    /**
     * 快捷注册 手机号+验证码
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function quickRegister(Request $request)
    {
        return RestResponseFactory::ok();
    }

}
