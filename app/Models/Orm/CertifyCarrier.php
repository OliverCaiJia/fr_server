<?php

namespace App\Models\Orm;

use App\Models\AbsBaseModel;

class CertifyCarrier extends AbsBaseModel
{
    public $timestamps = true;

    /**
     *
     *  设置表名
     */
    const TABLE_NAME = 'certify_carriers';
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
        'application_check' => 'array',
        'collection_contact' => 'array',
        'user_basic' => 'array',
        'basic_check_items' => 'array',
        'cell_behavior' => 'array',
        'call_contact_detail' => 'array',
        'contact_region' => 'array',
        'behavior_check' => 'array',
        'call_family_detail' => 'array',
        'call_risk_analysis' => 'array',
        'user_info_check' => 'array',
        'contacts' => 'array'
    ];
}
