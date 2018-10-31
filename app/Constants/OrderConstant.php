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

    const ORDER_STATUS_MAP = [
        self::ORDER_STATUS_PENDING => '待处理',
        self::ORDER_STATUS_PASSED => '已通过',
        self::ORDER_STATUS_REFUSED => '已拒绝'
    ];
}
