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
     * 添加用户user_info
     */
    public static function createUserInfo($data)
    {
        return UserInfo::insert($data);
    }
}