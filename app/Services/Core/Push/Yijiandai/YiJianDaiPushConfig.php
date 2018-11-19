<?php

/**
 * Created by PhpStorm.
 * User: sudai
 * Date: 17-9-4
 * Time: 下午1:50
 */

namespace App\Services\Core\Push\Yijiandai;


class YiJianDaiPushConfig
{

    const YIJIANDAI_PUSH_URL = 'http://uat.api.1sudai.com/api/v1/cooperator/user'; //一键贷推送ApiUrl(测试)
//    const YIJIANDAI_PUSH_URL = 'https://api.yijiandai365.com/api/v1/cooperator/user'; //一键贷推送ApiUrl(正式)

    const YIJIANDAI_PULL_URL = 'http://uat.api.1sudai.com/api/v1/cooperator/user/result'; //一键贷拉取ApiUrl(测试)
//    const YIJIANDAI_PULL_URL = 'https://api.yijiandai365.com/api/v1/cooperator/user/result'; //一键贷拉取ApiUrl(正式)

    const YIJIANDAI_KEY = '7BFCF5C921231SDZ'; //一键贷key(测试)
//    const YIJIANDAI_KEY = '6SW3SLDKKSAS3AFC'; //一键贷key(正式)

    const YIJIANDAI_CHANNEL = 'oneloan_165'; //一键贷渠道


}
