<?php

namespace App\Models\Orm;

use App\Models\AbsBaseModel;

class UserOrderRefuseLoanReason extends AbsBaseModel
{
    const TABLE_NAME = 'saas_order_refuse_loan_reasons';
    const PRIMARY_KEY = 'id';
    public $timestamps = true;

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