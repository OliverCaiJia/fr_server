<?php

namespace App\Helpers;

class IfJson
{
    /**
     * 判断数据不是JSON格式
     * @param $str
     * @return bool
     */
    public static function isNotJson($str)
    {
        return is_null(json_decode($str));
    }
}
