<?php

namespace App\Models\Factory\Api;

use App\Helpers\Utils;
use App\Helpers\Generator\TokenGenerator;
use App\Models\Orm\UserAuth;

/**
 * Class UserAuthFactory
 * @package App\Models\Factory\Api
 * 用户
 */
class UserAuthFactory extends ApiFactory
{
    /**
     * 通过用户主键ID获取用户
     * @param $userId
     * @return mixed|string
     */
        public static function getUserById($userId)
    {
        $user = UserAuth::where('id', '=', $userId)->first();

        return $user ? $user->toArray() : [];
    }

    /**
     * 通过用户token获取用户
     * @param $token
     * @return mixed|string
     */
    public static function getUserByToken($token)
    {
        $user = UserAuth::where('access_token', '=', $token)->first();

        return $user ? $user->toArray() : [];
    }

    /**
     * 通过用户mobile获取用户
     * @param $mobile
     * @return mixed|string
     */
    public static function getUserByMobile($mobile)
    {
        $user = UserAuth::where('mobile', '=', $mobile)->first();

        return $user ? $user->toArray() : [];
    }

    /**
     * 通过用户token获取用户主键Id
     * @param $token
     * @return mixed|string
     */
    public static function getUserIdByToken($token)
    {
        $userId = UserAuth::where('access_token', '=', $token)->value('id');

        return $userId ?? '';
    }

    /**
     * 通过用户mobile获取用户主键Id
     * @param $mobile
     * @return mixed|string
     */
    public static function getUserIdByMobile($mobile)
    {
        $userId = UserAuth::where('mobile', '=', $mobile)->value('id');

        return $userId ?? '';
    }

    /**
     * 从用户主表中获取用户的手机号和是否设置密码
     * @param $mobile
     */
    public static function getMobileAndIndent($mobile)
    {
        return UserAuth::where('mobile', '=', $mobile)->where('status', '=', '1')->first();
    }

    /**
     * 通过用户主键userId获取用户mobile
     * @param $userId
     * @return mixed|string
     */
    public static function getUserMobileById($userId)
    {
        $mobile = UserAuth::where('id', '=', $userId)->value('mobile');

        return $mobile ?? '';
    }

    /**
     * 返回用户name
     */
    public static function fetchUserName($userId)
    {
        $userAuth = UserAuth::select(['user_name', 'mobile'])->where(['id' => $userId])->first();
        return isset($userAuth->user_name) ? trim($userAuth->user_name) : "";
    }


    /**
     * 通过用户token获取用户mobile
     * @param $userId
     * @return mixed|string
     */
    public static function getUserMobileByToken($userId)
    {
        $mobile = UserAuth::where('id', '=', $userId)->value('mobile');

        return $mobile ?? '';
    }

    /**
     * 通过用户主键userId获取用户access_token
     * @param $userId
     * @return mixed|string
     */
    public static function getUserTokenById($userId)
    {
        $token = UserAuth::where('id', '=', $userId)->value('access_token');

        return $token ?? '';
    }

    /** 更新用户最后登录时间
     * @param $userId
     * @return mixed
     */
    public static function updateLoginTime($userId)
    {
        return UserAuth::where('id', $userId)->update([
            'last_login_at' => date('Y-m-d H:i:s'),
            'last_login_ip' => Utils::ipAddress(),
        ]);
    }

    /**
     * @param $userId
     * @param $data
     * 更新用户信息
     */
    public static function updateUserData($userId,$data){
        return UserAuth::where('id', $userId)->update($data);
    }

    /** 新增/更新用户
     * @param $data
     * @return mixed
     */
    public static function updateOrCreate($data)
    {
        return UserAuth::updateOrCreate(['mobile' => $data['mobile']], $data);
    }

    /**
     * 设置用户密码和Token
     * @param $user_id
     * @param $password
     */
    public static function setUserPasswordAndToken($userId, $password)
    {
        return UserAuth::where('id', '=', $userId)->update(['password' => $password, 'access_token' => TokenGenerator::generateToken()]);
    }

    /**
     * 设置用户密码
     * @param $user_id
     * @param $password
     */
    public static function setUserPassword($userId, $password)
    {
        return UserAuth::where('id', '=', $userId)->update(['password' => $password]);
    }

    /**
     * @param $mobile
     * @param $pwd
     * @return mixed
     * 忘记密码 —— 修改密码
     */
    public static function updatePwdByMobile($mobile, $pwd)
    {
        $updateMobile = UserAuth::where(['mobile' => $mobile])
            ->update(['password' => $pwd]);

        return $updateMobile;
    }

    /**
     * 修改用户主表中的status 为激活状态 1
     * @param $user_id
     */
    public static function setUserStatus($userId)
    {
        return UserAuth::where('id', '=', $userId)->update(['status' => 1]);
    }

    /**
     * 更新用户的accessToken
     */
    public static function updateUserTokenById($userId, $token)
    {
        return UserAuth::where('id', '=', $userId)->update(['access_token' => $token]);
    }

    /**
     * 添加用户
     */
    public static function createUser($data)
    {
        return UserAuth::insert($data);
    }

    /**
     * 根据token获取用户信息
     * @param $accessToken
     * @return array
     */
    public static function getUserAuthByAccessToken($accessToken)
    {
        $userAuth = UserAuth::select()
            ->where('access_token', '=', $accessToken)
            ->first();
        return $userAuth ? $userAuth->toArray() : [];
    }
}
