<?php

namespace App\Models\Orm;

use App\Models\AbsBaseModel;

class UserChannel extends AbsBaseModel
{
    /**
     *
     *  设置表名
     */
    const TABLE_NAME = 'user_channel';
    const PRIMARY_KEY = 'id';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = self::TABLE_NAME;
    //主键id
    protected $primaryKey = self::PRIMARY_KEY;
    //查询字段
    protected $visible = [];
    //加黑名单
    protected $guarded = [];
}
