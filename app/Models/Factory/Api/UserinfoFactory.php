<?php

namespace App\Models\Factory\Api;

use App\Models\AbsModelFactory;
use App\Models\Orm\UserInfo;

/**
 * Class UserinfoFactory
 * @package App\Models\Factory
 * 用户信息工厂类
 */
class UserinfoFactory extends AbsModelFactory
{

    /**
     * 获取用户信息
     * @param $user_id
     * @return array
     */
    public static function getUserInfoByUserId($user_id){
        $user_res = UserInfo::where('user_id','=',$user_id)->first();
        return $user_res ? $user_res->toArray() : [];
    }

    /**
     * 添加用户user_info
     */
    public static function createUserInfo($data)
    {
        return UserInfo::insert($data);
    }

    /**
     * @param $user_id
     * @return mixed
     * 修改用户状态
     */
    public static function UpdateUserInfoStatus($user_id,$data){
        return UserInfo::where('user_id','=',$user_id)
            ->update($data);
    }
}