<?php

namespace App\Models\Orm;

use App\Models\AbsBaseModel;

class UserAccount extends AbsBaseModel
{
    public $timestamps = false;
    public $incrementing = true;

    /**
     *
     *  设置表名
     */
    const TABLE_NAME = 'user_account';
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
    //隐藏字段
    protected $hidden = [''];
}
