<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\RestUtils;
use App\Helpers\Utils;
use App\Models\Factory\Api\UserAuthFactory;
use App\Models\Factory\Api\UserRealnameFactory;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Strategies\UserStatusStrategy;
use App\Helpers\RestResponseFactory;
use App\Services\AppService;
use App\Models\Chain\Register\DoRegisterHandler;

class UserController extends ApiController
{
    /**
     * 用户注册
     * @param Request $request
     */
    public function register(Request $request)
    {
        $data = $request->all();
        #如果用户未激活调用注册责任链
        $register = new DoRegisterHandler($data);
        $re = $register->handleRequest();
        if (isset($re['error'])) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), $re['error'], $re['code'], $re['error']);
        }
        return RestResponseFactory::ok($re);
    }

    /**
     * 设置密码
     * @param Request $request
     */
    public function updatePwd(Request $request)
    {
        $user_id = $this->getUserId($request);
        $password = $request->input('password', '');
        $reset_token = $request->input('reset_token', false);

        //强制转换为bool型
        $reset_token = is_bool($reset_token) ? $reset_token : (bool)$reset_token;

        if ($password) {
            if ($reset_token === true) {
                $re = UserAuthFactory::setUserPasswordAndToken($user_id, $password);
                $data['need_relogin'] = true;
                $message = '密码修改成功,请重新登陆。';
            } else {
                $re = UserAuthFactory::setUserPassword($user_id, $password);
                $data['need_relogin'] = false;
                $message = '设置密码成功。';
            }

            if ($re) {
                UserFactory::setUserActivated($user_id);

                return RestResponseFactory::ok($data, $message);
            }
        }
        return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1109), 1109);
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

    /**获取用户身份证信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function serInfo(Request $request)
    {
        $uid = $this->getUserId($request);
        $data = UserRealnameFactory::fetchUserRealname($uid);
        if (empty($data)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1500), 1500);
        }
        return RestResponseFactory::ok($data);
    }

    /**用户认证状态
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userAuthenticationStatus(Request $request)
    {
        $uid = $this->getUserId($request);
        $data = UserStatusStrategy::getUserInfo($uid);
        if (empty($data)) {
            $data['service_status'] = 0;
            $data['has_userinfo'] = 0;
            $data['url'] = AppService::WEB_URL.'web/v1/user/info/create';
            return RestResponseFactory::ok($data);
        }
        $data['url'] = AppService::WEB_URL.'web/v1/user/info/create';
        return RestResponseFactory::ok($data);
    }

}