<?php

namespace App\Strategies;

use App\Constants\CertifyConstant;
use App\Models\Factory\Admin\Order\CertifyTaobaoFactory;

/**
 * 支付宝电商(淘宝)认证策略
 * Class OrderRuleStrategy
 * @package App\Strategies
 */
class CertifyTaobaoStrategy extends AppStrategy
{
    /**
     * 获取支付宝电商(淘宝)认证成功数据
     * @param $taobaoId
     * @return array|mixed
     */
    public static function getAndDealTaobaoInfoById($taobaoId)
    {
        $taobaoInfo = [];

        if ($taobaoId != 0) {
            $params = [
                'where' => [
                    'id' => $taobaoId,
                    'status' => CertifyConstant::CERTIFY_SUCCESS
                ]
            ];
            $taobaoInfo = CertifyTaobaoFactory::getOne($params);
        }

        return $taobaoInfo;
    }
}
