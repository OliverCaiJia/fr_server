<?php

return [
    /**
     * 订单类型配置
     * 付费订单：pay_order 免费订单：free_order
     */

    'pay_order' => ['order_report','order_extra_service'],
    'free_order' => ['order_apply','order_product'],
];
