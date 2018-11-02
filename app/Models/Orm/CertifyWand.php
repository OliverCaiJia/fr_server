<?php

namespace App\Models\Orm;

use App\Models\AbsBaseModel;

class CertifyWand extends AbsBaseModel
{
    public $timestamps = false;
    public $incrementing = true;

    /**
     *
     *  设置表名
     */
    const TABLE_NAME = 'certify_wands';
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
    protected $hidden = [];

    protected $casts = [
        'person_info' => 'array',
        'verification_info' => 'array',
        'register_info' => 'array',
        'queried_detail' => 'array',
        'black_info_detail' => 'array',
        'gray_info_detail' => 'array',
        'suspicious_idcard' => 'array',
        'suspicious_mobile' => 'array',
        'mobile_infos' => 'array',
        'fund_infos' => 'array',
        'debit_card_info' => 'array',
        'credit_card_info' => 'array',
    ];
}
