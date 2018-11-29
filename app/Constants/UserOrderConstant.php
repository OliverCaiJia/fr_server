<?php

namespace App\Constants;

use App\Constants\AppConstant;

/**
 * 用户订单常量定义
 * Class UserOrderConstant
 * @package App\Constants
 */
class UserOrderConstant extends AppConstant
{
    const ORDER_SUCCESS_STATUS = 1;
    const ORDER_REPORT_CREDIT = 'report_credit';
    const ORDER_REPORT_EVALUATION = 'report_evaluation';

    const ORDER_REPORT =
        [
            self::ORDER_REPORT_CREDIT => 'order_report',
            self::ORDER_REPORT_EVALUATION => 'order_report'
        ];
}

