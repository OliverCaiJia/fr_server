<?php

namespace App\Constants;

class WandConstant extends AppConstant
{
    const ORG_TYPE_MAP = [
        'CASH_LOAN' => '现金贷',
        'COMPENSATION' => '信用卡代偿',
        'CONSUMSTAGE' => '消费分期',
        'CREDITPAY' => '信用支付',
        'DATACOVERGE' => '数据聚合平台',
        'DIVERSION' => '导流平台',
        'P2P' => 'P2P理财',
        'ZHENGXIN' => '征信机构',
        'DATA_PLATFORM' => '平台',
        '其它' => '其它'
    ];
}
