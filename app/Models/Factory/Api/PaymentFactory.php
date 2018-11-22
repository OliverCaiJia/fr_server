<?php

namespace App\Models\Factory\Api;

use App\Models\Factory\Api\ApiFactory;
use App\Models\Orm\Payment;
use App\Models\Orm\PaymentType;
use App\Models\Orm\UserAccountType;

class PaymentFactory extends ApiFactory
{
    /**
     * 获取支付渠道ID
     *
     * @return mixed|string
     */
    public static function getPaymentType($nid)
    {
        $id = PaymentType::where(['nid' => $nid])->value('id');

        return $id ? $id : 1;
    }

    /**
     * 通过唯一标识获取支付信息
     * @param $nid
     * @return array
     */
    public static function getPaymentByNid($nid)
    {
        $payment = Payment::where(['nid' => $nid])->get();

        return $payment ? $payment->toArray() : [];
    }

    /**
     * 根据支付唯一标识更新支付状态
     * @param $nid
     * @param $status
     * @return mixed
     */
    public static function updatePaymentStatusByNid($nid, $status)
    {
        return Payment::where('nid', '=', $nid)->update(['status' => $status]);
    }

}
