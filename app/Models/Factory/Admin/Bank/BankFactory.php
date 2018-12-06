<?php

namespace App\Models\Factory\Admin\Bank;

use App\Models\AbsModelFactory;
use App\Models\Orm\Bank;

class BankFactory extends AbsModelFactory
{

    public static function getBankName($id){
       $bankName = Bank::where(['id'=>$id])->first();
       return $bankName ? $bankName->bank_name: '';
    }

}
