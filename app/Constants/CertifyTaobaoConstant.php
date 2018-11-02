<?php

namespace App\Constants;

class CertifyTaobaoConstant extends AppConstant
{
    // 支付方式
    const PAYTYPE_YUEBAO = 1;
    const PAYTYPE_HUABEI = 2;
    const PAYTYPE_BANKCARD = 3;
    const PAYTYPE_MAP = [
        self::PAYTYPE_YUEBAO => '余额宝',
        self::PAYTYPE_HUABEI => '花呗',
        self::PAYTYPE_BANKCARD => '银行卡'
    ];

    // 交易类型
    const TXTYPEDID_REPAY_CERTIFYCARD = 30;
    const TXTYPEDID_REPAY_FEIJIETIAO = 93;
    //交易类型名称
    const TXTYPENAME_MAP = [
        self::TXTYPEDID_REPAY_CERTIFYCARD => '信用卡还款',
        self::TXTYPEDID_REPAY_FEIJIETIAO => '非借条还款',
    ];
}
