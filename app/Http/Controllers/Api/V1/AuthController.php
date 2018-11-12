<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\Helpers\RestResponseFactory;
use App\Models\Chain\Login\DoLoginHandler;
use App\Helpers\Generator\TokenGenerator;
use App\Helpers\RestUtils;
use App\Models\Factory\Api\UserAuthFactory;
use App\Models\Chain\FastLogin\DoFastLoginHandler;

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
        $userId = $request->user_id;
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
        #查库检查用户手机号是否存在并且status 是否为0
        $user = UserAuthFactory::getMobileAndIndent($data['mobile']);
        if ($user)
        {
            #如果用户激活则调用登录责任链
            $login = new DoFastLoginHandler($data);
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
                'is_exist' => 1, //用户是否存在 0 未存在,1 存在
                'access_token' => $re['access_token'],
            ];
            return RestResponseFactory::ok($re);
        }
        else
        {
            //用户信息重组
            $re = [
                'user_id' => '',
                'mobile' => $data['mobile'],
                'status' => '',
                'is_exist' => 0, //用户是否存在 0 未存在,1 存在
                'access_token' => '',
            ];
            return RestResponseFactory::ok($re);
        }
    }

}
