<?php

namespace App\Models\Factory\Admin\Users;

use App\Models\AbsModelFactory;
use App\Models\Orm\UserReport;

class UserReportFactory extends AbsModelFactory
{
    /**
     * 通过 where 条件获取 id
     *
     * @param $where
     *
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public static function getIdByWhere($where)
    {
        return UserReport::where($where)->first();
    }
}
