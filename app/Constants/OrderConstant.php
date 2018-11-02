<?php

namespace App\Constants;

class OrderConstant extends AppConstant
{
    // 订单还款方式常量
    const ORDER_PAYMENT_METHOD_ONCE = 1;
    const ORDER_PAYMENT_METHOD_MULTI_TIME = 2;
    const ORDER_PAYMENT_METHOD = [
        self::ORDER_PAYMENT_METHOD_ONCE => '一次还',
        self::ORDER_PAYMENT_METHOD_MULTI_TIME => '分期还',
    ];

    // 订单状态
    const ORDER_STATUS_PENDING = 1;
    const ORDER_STATUS_PASSED = 2;
    const ORDER_STATUS_REFUSED = 3;
    const ORDER_STATUS_LOAN_REFUSED = 4;
    const ORDER_STATUS_LOAN_PENDING = 5;
    const ORDER_STATUS_LOAN_OVERDUE = 6;
    const ORDER_STATUS_LOAN_FINISHED = 7;

    const ORDER_STATUS_MAP = [
        self::ORDER_STATUS_PENDING => '待初审',
        self::ORDER_STATUS_PASSED => '待放款',
        self::ORDER_STATUS_REFUSED => '初审不通过',
        self::ORDER_STATUS_LOAN_REFUSED => '已拒绝放款',
        self::ORDER_STATUS_LOAN_PENDING => '待还款订单',
        self::ORDER_STATUS_LOAN_OVERDUE => '逾期未还订单',
        self::ORDER_STATUS_LOAN_FINISHED => '已还款订单',
    ];

    // 订单申请状态
    const ORDER_APPLY_STATUS_REGISTER = 1;
    const ORDER_APPLY_STATUS_IDENTITY = 2;
    const ORDER_APPLY_STATUS_APPLY = 3;

    const ORDER_APPLY_STATUS_MAP = [
        self::ORDER_APPLY_STATUS_REGISTER => '注册完成',
        self::ORDER_APPLY_STATUS_IDENTITY => '实名完成',
        self::ORDER_APPLY_STATUS_APPLY => '申请完成'
    ];

    //订单还款方式
    const ORDER_REPAYMENT_METHOD_WECHAT = 1;
    const ORDER_REPAYMENT_METHOD_ZHIFUBAO = 2;
    const ORDER_REPAYMENT_METHOD_OTHERS = 3;

    const ORDER_REPAYMENT_METHOD_MAP = [
        self::ORDER_REPAYMENT_METHOD_WECHAT => '微信',
        self::ORDER_REPAYMENT_METHOD_ZHIFUBAO => '支付宝',
        self::ORDER_REPAYMENT_METHOD_OTHERS => '其他'
    ];

    //订单还款类型
    const ORDER_REPAYMENT_TYPE_NORMAL = 1;
    const ORDER_REPAYMENT_TYPE_ADVANCE = 2;
    const ORDER_REPAYMENT_TYPE_OVERDUE = 3;

    const ORDER_REPAYMENT_TYPE_MAP = [
        self::ORDER_REPAYMENT_TYPE_NORMAL => '正常还款',
        self::ORDER_REPAYMENT_TYPE_ADVANCE => '提前还款',
        self::ORDER_REPAYMENT_TYPE_OVERDUE => '逾期还款'
    ];

    const CERTIFY_ITEM_ID_TEXTS = [
        'basic_info_id' => '三要素一致性',
        'carrier_id' => '运营商',
        'iou_platform_id' => '借条平台',
        'zhima_id' => '芝麻分',
        'taobao_id' => '淘宝 | 支付宝',
        'multilateral_lending_id' => '多头借贷',
        'wand_id' => '综合信用',
    ];
}
