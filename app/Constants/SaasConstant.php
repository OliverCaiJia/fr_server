<?php

namespace App\Constants;

class SaasConstant extends AppConstant
{
    // 账户冻结
    const SAAS_USER_LOCKED_TRUE = 1;
    // 账户没有冻结
    const SAAS_USER_LOCKED_FALSE = 0;
    // 账户删除
    const SAAS_USER_DELETED_TRUE = 1;
    // 账户正常
    const SAAS_USER_DELETED_FALSE = 0;
    // 合作方审查条件关系状态删除
    const SAAS_FILTER_DELETED_TRUE = 1;
    // 合作方审查条件关系状态正常
    const SAAS_FILTER_DELETED_FALSE = 0;
    // 合作方审查条件类别关系状态删除
    const SAAS_FILTER_TYPE_DELETED_TRUE = 1;
    // 合作方审查条件类别关系状态正常
    const SAAS_FILTER_TYPE_DELETED_FALSE = 0;

    // 合作方默认登录密码
    const SAAS_USER_DEFAULT_PASSWORD = '000000';

    // 合作方审查条件参数前缀
    const SAAS_FILTER_PREFIX = ':param';

    // 合作方审查条件参数默认值 参数标识 => 参数值
    const SAAS_FILTER_DEFAULT_TYPE_PARAMS = [
        'repeated_apply_ignore_days' => 30,            // 默认不允许重复申请参数30天
    ];
}
