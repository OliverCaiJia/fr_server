<?php

namespace App\Models\Orm;

use App\Models\AbsBaseModel;

class CertifyIouPlatform extends AbsBaseModel
{
    public $timestamps = true;

    /**
     *
     *  设置表名
     */
    const TABLE_NAME = 'certify_iou_platforms';
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

    protected $casts = [
        'jiedaibao_info' => 'array',
        'gushistory_info' => 'array',
    ];
}
