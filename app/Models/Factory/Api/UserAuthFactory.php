<?php

namespace App\Models\Factory\Api;

use App\Helpers\Utils;
use App\Models\Orm\UserAuth;
use App\Helpers\Generator\TokenGenerator;


class UserAuthFactory extends ApiFactory
{
    /**
     * 通过用户主键ID获取用户
     *
     * @param $userId
     *
     * @return mixed|string
     */
    public static function getUserById($userId)
    {
        return UserAuth::where('id', '=', $userId)->first();
    }

    /**
     * 通过用户token获取用户
     *
     * @param $token
     *
     * @return mixed|string
     */
    public static function getUserByToken($token)
    {
        return UserAuth::where('access_token', '=', $token)->first();
    }

    /**
     * 通过用户mobile获取用户
     *
     * @param $mobile
     *
     * @return mixed|string
     */
    public static function getUserByMobile($mobile)
    {
        return UserAuth::where('mobile', '=', $mobile)->first();
    }

    /**
     * 通过用户token获取用户主键Id
     *
     * @param $token
     *
     * @return mixed|string
     */
    public static function getUserIdByToken($token)
    {
        return UserAuth::where('access_token', '=', $token)->value('id');
    }

    /**
     * 通过用户mobile获取用户主键Id
     *
     * @param $mobile
     *
     * @return mixed|string
     */
    public static function getUserIdByMobile($mobile)
    {
        return UserAuth::where('mobile', '=', $mobile)->value('id');
    }

    /**
     * 通过用户主键userId获取用户mobile
     *
     * @param $userId
     *
     * @return mixed|string
     */
    public static function getUserMobileById($userId)
    {
        return UserAuth::where('id', '=', $userId)->value('mobile');
    }

    /**
     * 通过用户token获取用户mobile
     *
     * @param $userId
     *
     * @return mixed|string
     */
    public static function getUserMobileByToken($userId)
    {
        return UserAuth::where('id', '=', $userId)->value('mobile');
    }

    /**
     * 通过用户主键userId获取用户access_token
     *
     * @param $userId
     *
     * @return mixed|string
     */
    public static function getUserTokenById($userId)
    {
        return UserAuth::where('id', '=', $userId)->value('access_token');
    }

    /** 更新用户最后登录时间
     * @param $userId
     * @return mixed
     */
    public static function updateLoginTime($userId)
    {
        return UserAuth::where('id', $userId)->update([
            'last_login_time' => date('Y-m-d H:i:s'),
            'last_login_ip' => Utils::ipAddress(),
        ]);
    }

    /** 新增/更新用户
     * @param $data
     * @return mixed
     */
    public static function updateOrcreate($data)
    {
        $userAuth = UserAuth::updateOrCreate(['mobile' => $data['mobile']], $data);
        return $userAuth;
    }

}
