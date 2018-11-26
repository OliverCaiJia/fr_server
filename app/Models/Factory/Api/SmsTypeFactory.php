<?php

namespace App\Models\Factory\Api;

use App\Models\Orm\SmsType;


/**
 * Class ProductFactory
 * @package App\Models\Factory\Api
 * 短信类型
 */
class SmsTypeFactory extends ApiFactory
{
    /**
     * 获取短信类型
     */
    public static function getSmsType($message_type_nid)
    {
        $smsType = SmsType::where(['message_type_nid' => $message_type_nid,'status' => 1])->first();

        return $smsType ? $smsType->toArray() : [];
    }
}
