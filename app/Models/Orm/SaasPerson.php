<?php

namespace App\Models\Orm;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SaasPerson extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;
    public $incrementing = true;

    /**
     * The column name of the "remember me" token.
     *
     * @var string
     */
    protected $rememberTokenName = '';

    /**
     *
     *  设置表名
     */
    const TABLE_NAME = 'admin_persons';
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
    protected $hidden = ['password'];

    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'create_id',
        'saas_auth_id',
        'position',
        'department',
        'mobilephone'
    ];

    public function roles()
    {
        return $this->belongsToMany(SaasRole::class, 'admin_role_user', 'user_id', 'role_id');
    }

    // 判断用户是否具有某权限
    public function hasPermission($permission)
    {
        if (is_string($permission)) {
            $permission = SaasPermission::where('name', $permission)->first();
            if (!$permission) {
                return false;
            }
        }

        return $this->hasRole($permission->roles);
    }

    // 判断用户是否具有某个角色
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        return !!$role->intersect($this->roles)->count();
    }
}
