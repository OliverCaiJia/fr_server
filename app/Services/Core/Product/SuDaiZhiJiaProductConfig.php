<?php

/**
 * Created by PhpStorm.
 * User: sudai
 * Date: 17-9-4
 * Time: 下午1:50
 */

namespace App\Services\Core\Product;


class SuDaiZhiJiaProductConfig
{

    const SUDAIZHIJIA_PRODUCT_URL = PRODUCTION_ENV ? 'https://api.sudaizhijia.com/v5/products': 'https://uat.api.sudaizhijia.com/v5/products'; //速贷之家合作贷产品url(测试)

    const SUDAIZHIJIA_APPLY_URL = PRODUCTION_ENV ? 'https://api.sudaizhijia.com/v1/product/web/url': 'https://uat.api.sudaizhijia.com/v1/product/web/url';//速贷之家立即申请产品url(测试)

}
