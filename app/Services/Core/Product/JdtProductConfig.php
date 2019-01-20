<?php

namespace App\Services\Core\Product;


class JdtProductConfig
{

    const SUDAIZHIJIA_PRODUCT_URL = PRODUCTION_ENV ? 'https://api.jdt.com/v5/products': 'https://at.api.jdt.com/v5/products'; //jdt合作贷产品url(测试)

    const SUDAIZHIJIA_APPLY_URL = PRODUCTION_ENV ? 'https://api.jdt.com/v1/product/web/url': 'https://at.api.jdt.com/v1/product/web/url';//jdt立即申请产品url(测试)

}
