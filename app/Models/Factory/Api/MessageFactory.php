<?php

namespace App\Models\Factory\Api;

use App\Models\Factory\Api\ApiFactory;
use App\Models\Orm\Message;

/**
 * Class BanksFactory
 * @package App\Models\Factory
 * 短信工厂log
 */
class MessageFactory extends ApiFactory
{
    /**
     * @return bool
     * 添加短信log
     */
    public static function messageAdd($data)
    {
        $addMessage = Message::save($data);

        return $addMessage;
    }
}