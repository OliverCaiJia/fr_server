<?php

namespace App\Models\Orm;

use App\Models\AbsBaseModel;

class SaasPermission extends AbsBaseModel
{
    public $timestamps = false;
    public $incrementing = true;

    /**
     *
     *  设置表名
     */
    const TABLE_NAME = 'saas_permissions';
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

    public function roles()
    {
        return $this->belongsToMany(SaasRole::class, 'saas_permission_role', 'permission_id', 'role_id');
    }
}
