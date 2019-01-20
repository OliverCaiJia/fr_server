<?php

/**
 * Created by PhpStorm.
 * User: sudai
 * Date: 17-9-4
 * Time: 下午1:50
 */

namespace App\Services\Core\Push\Yij;


class YiJPushConfig
{

    const YIJIANDAI_PUSH_URL = PRODUCTION_ENV ? 'https://api.yjian.com/api/v1/cooperator/user': 'http://uat.api.1s.com/api/v1/cooperator/user'; //yj推送ApiUrl(测试)
//    const YIJIANDAI_PUSH_URL = 'https://api.yjian.com/api/v1/cooperator/user'; //一键贷推送ApiUrl(正式)

    const YIJIANDAI_PULL_URL = PRODUCTION_ENV ? 'https://api.yjian.com/api/v1/cooperator/user/result' : 'http://uat.api.1s.com/api/v1/cooperator/user/result'; //yj拉取ApiUrl(测试)
//    const YIJIANDAI_PULL_URL = 'https://api.yijiandai365.com/api/v1/cooperator/user/result'; //一键贷拉取ApiUrl(正式)

    const YIJIANDAI_KEY = PRODUCTION_ENV ? '6SWSLDKKSAS3AF' : '7BFF5C921231SD'; //一键贷key(测试)
//    const YIJIANDAI_KEY = '6SWSLDKKSAS3AF'; //yjkey(正式)

    const YIJIANDAI_CHANNEL = 'onel'; //yj渠道


}
