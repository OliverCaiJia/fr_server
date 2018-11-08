<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Request;
use App\Helpers\RestResponseFactory;

class AuthController extends ApiController
{

    /**
     * 普通登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $arr = [
            'code' => 200,
            'message' => 'OK',
            'data' => [
                'uid' => 1,
                'moblid' => '13999999999',
                'status' => 1,
                'access_token' => 'EQKDSGh69Koevj3zUgtO7L8D0YLLlWva',
            ],
            'error_code' => 0,
            'error_message' => '',
            'time' => '2017-09-05 10:43:55'
        ];

        return RestResponseFactory::ok($arr);
    }

    /**
     * 验证码快捷登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function quickLogin(Request $request)
    {
        $arr = [
            'code' => 200,
            'message' => 'OK',
            'data' => [
                'uid' => 1,
                'moblid' => '13999999999',
                'status' => 1,
                'access_token' => 'EQKDSGh69Koevj3zUgtO7L8D0YLLlWva',
            ],
            'error_code' => 0,
            'error_message' => '',
            'time' => '2017-09-05 10:43:55'
        ];
        return RestResponseFactory::ok($arr);
    }

    /**
     * 登出
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {

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
