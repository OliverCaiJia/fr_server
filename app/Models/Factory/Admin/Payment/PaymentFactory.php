<?php

namespace App\Models\Factory\Admin\Payment;

use App\Models\AbsModelFactory;
use App\Models\Orm\Payment;
use App\Models\Orm\PaymentType;

class PaymentFactory extends AbsModelFactory
{

    public static function getPaymentName($id){
       $paymentName = Payment::where(['id'=>$id])->first();
       return $paymentName ? $paymentName->name: '';
    }


    public static function getPaymentTypeName($id){
        $TypeName = PaymentType::where(['id'=>$id])->first();
        return $TypeName ? $TypeName->payment_type_name: '';
    }

}
