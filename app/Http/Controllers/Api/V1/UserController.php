<?php

namespace App\Http\Controllers\Api\V1;

use App\Constants\UserConstant;
use App\Helpers\RestUtils;
use App\Helpers\Utils;
use App\Models\Factory\AccountFactory;
use App\Models\Factory\AuthFactory;
use App\Models\Factory\Api\UserAuthFactory;
use App\Models\Factory\CreditFactory;
use App\Models\Factory\PhoneFactory;
use App\Models\Factory\UserFactory;
use App\Models\Factory\UserSignFactory;
use App\Models\Factory\Api\UserRealnameFactory;
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
        $userId = $request->input('user_id');
        $data = UserRealnameFactory::fetchUserRealname($userId);
        if (empty($data)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1500), 1500);
        }
        return RestResponseFactory::ok($data);


    }

}