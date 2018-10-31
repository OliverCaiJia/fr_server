<?php

namespace App\Strategies;

class OrderDetailStrategy extends AppStrategy
{
    /**
     *
     * @param $monthlyIncome
     *
     * @return string
     */
    public static function getMonthlyIncomeTextForBlade($monthlyIncome)
    {
        $end = mb_substr($monthlyIncome, -2);
        if ($end == '以上' || $end == '以下') {
            return mb_substr($monthlyIncome, 0, -2) . '元' . $end;
        }

        return $monthlyIncome . '元';
    }
}
