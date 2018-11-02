<?php

namespace App\Constants;

class CertifyConstant extends AppConstant
{
    // 认证状态
    const UNCERTIFIED = 0;
    const CERTIFING = 1;
    const CERTIFY_SUCCESS = 2;
    const CERTIFY_FAILED = 3;
    const CERTIFY_MAP = [
        self::UNCERTIFIED => '未认证',
        self::CERTIFING => '认证中',
        self::CERTIFY_SUCCESS => '认证成功',
        self::CERTIFY_FAILED => '认证失败'
    ];
}
