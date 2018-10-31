<?php

namespace App\Strategies;

use App\Constants\WandConstant;

class WandStrategy extends AppStrategy
{
    /**
     * @param array $orgTypes
     *
     * @return string
     */
    public static function getOrgTypeText(array $orgTypes)
    {
        $types = [];
        foreach ($orgTypes as $orgType) {
            if (in_array($orgType, array_keys(WandConstant::ORG_TYPE_MAP))) {
                $types[] = WandConstant::ORG_TYPE_MAP[$orgType];
            }
        }
        return implode(',', $types);
    }
}
