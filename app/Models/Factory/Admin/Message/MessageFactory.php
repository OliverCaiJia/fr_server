<?php

namespace App\Models\Factory\Admin\Message;

use App\Models\AbsModelFactory;
use App\Models\Orm\SmsType;

class MessageFactory extends AbsModelFactory
{
    /**
     * 通过用户主键ID获取用户名
     *
     * @param $id
     *
     * @return mixed|string
     */
    public static function getSmdTypeName($id)
    {
        $smsType = SmsType::select('message_type_name')->find($id)->first();

        return $smsType ? $smsType->message_type_name : '未知';
    }
}
