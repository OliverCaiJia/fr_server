<?php

namespace App\Models\Orm;

use App\Models\AbsBaseModel;

class CertifyTaobao extends AbsBaseModel
{
    const TABLE_NAME = 'certify_taobaos';
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

    protected $casts = [
        'ecommerce_base_info' => 'array',
        'ecommerce_trades' => 'array',
        'ecommerce_consignee_addresses' => 'array',
        'ecommerce_binded_bank_cards' => 'array',
        'ecommerce_payment_accounts' => 'array',
        'taobao_orders' => 'array',
        'sold_orders' => 'array',
        'huabei_consume_list' => 'array',
        'jiebei_info' => 'array',
        'huabei_info' => 'array',
        'transfer_bank_cards' => 'array',
        'huabei_bills' => 'array',
        'my_bank_bind_info' => 'array',
        'my_bank_loan_details' => 'array',
        'my_bank_repay_plan_list' => 'array',
        'my_bank_asset_details' => 'array',
        'alipay_bill_detail_list' => 'array'
    ];
}
