<?php

namespace App\Models\Orm;

use App\Models\AbsBaseModel;

class SaasRole extends AbsBaseModel
{
    public $timestamps = true;
    public $incrementing = true;

    /**
     *
     *  设置表名
     */
    const TABLE_NAME = 'admin_roles';
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

    public function permissions()
    {
        return $this->belongsToMany(SaasPermission::class, 'admin_permission_role', 'role_id', 'permission_id');
    }

    public function persons()
    {
        return $this->belongsToMany(SaasPerson::class, 'admin_role_user', 'role_id', 'user_id');
    }
}
