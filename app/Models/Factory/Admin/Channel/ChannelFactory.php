<?php

namespace App\Models\Factory\Admin\Channel;

use App\Models\AbsModelFactory;
use App\Models\Orm\Channel;
use App\Models\Orm\UserChannel;

class ChannelFactory extends AbsModelFactory
{

    /**获取name
     * @param $id
     * @return string
     */
    public static function getTypeName($id)
    {
        $typename = Channel::where(['id' => $id])->first();
        return $typename ? $typename->channel_title : '';
    }

    /**获取Nid
     * @param $id
     * @return string
     */
    public static function getTypeNid($id)
    {
        $typename = Channel::where(['id' => $id])->first();
        return $typename ? $typename->channel_nid : '';
    }

    public static function getCount($id)
    {
        $user_count = UserChannel::where(['channel_id' => $id])->count();
        return $user_count ? $user_count : "";
    }

}
