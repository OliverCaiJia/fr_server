<?php

namespace App\Models\Factory\Admin\Banner;

use App\Models\AbsModelFactory;
use App\Models\Orm\BannerType;

class BannerFactory extends AbsModelFactory
{

    public static function getTypeName($id){
       $typename = BannerType::where(['id'=>$id])->first();
       return $typename ? $typename->type: '';
    }

}
