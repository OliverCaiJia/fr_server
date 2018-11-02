<?php

namespace App\Models\Factory\Admin;

use App\Models\AbsModelFactory;
use App\Models\Orm\AdminUser;

class AdminUserFactory extends AbsModelFactory
{
    /**
     * 通过用户主键ID获取用户名
     *
     * @param $id
     *
     * @return mixed|string
     */
    public static function getNameById($id)
    {
        $user = AdminUser::select('name')->find($id)->first();

        return $user ? $user->name : '未知';
    }
}
