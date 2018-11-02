<?php

namespace App\Models\Factory\Saas\Channel;

use App\Models\AbsModelFactory;
use App\Models\Orm\SaasChannel;

class ChannelFactory extends AbsModelFactory
{
    public static function getNameById($id)
    {
        $channel = SaasChannel::select('name')->find($id);
        return $channel->name ?? '未知';
    }

    /**
     * 通过渠道id获取渠道信息
     * @param $id
     * @return array
     */
    public static function getChannelInfoById($id)
    {
        $channel = SaasChannel::where('id', '=', $id)->first();
        return $channel ? $channel->toArray() : [];
    }
}
