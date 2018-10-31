<?php

namespace App\Constants;

class ChannelConstant extends AppConstant
{
    // 渠道类型-非定向
    const SAAS_CHANNEL_TYPE_UNDIRECTED = 2;
    // 渠道类型-定向
    const SAAS_CHANNEL_TYPE_DIRECTED = 1;
    // 渠道类型-其他
    const SAAS_CHANNEL_TYPE_OTHERS = 0;

    const SAAS_CHANNEL_TYPE_MAP = [
        self::SAAS_CHANNEL_TYPE_UNDIRECTED => '非定向',
        self::SAAS_CHANNEL_TYPE_DIRECTED => '定向',
        self::SAAS_CHANNEL_TYPE_OTHERS => '其他'
    ];
}
