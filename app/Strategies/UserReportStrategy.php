<?php

namespace App\Strategies;

use App\Models\Factory\Admin\Order\SaasOrderFactory;
use App\Models\Factory\Admin\Saas\SaasPersonFactory;
use Carbon\Carbon;
use Medz\IdentityCard\China\Identity;

class UserReportStrategy extends AppStrategy
{
    /**
     * 拼接月收入
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

    /**
     * 通过身份证号码解析年龄
     *
     * @param $idCard
     *
     * @return int|string
     */
    public static function getAgeByIdCardForBlade($idCard)
    {
        if (!$idCard) {
            return '暂无数据';
        }

        try {
            $peopleIdentity = new Identity($idCard);

            if (!$peopleIdentity->legal()) {
                return '暂无数据';
            }

            $birthday = Carbon::createFromFormat('Y-m-d', $peopleIdentity->birthday());

            return $birthday->diffInYears();
        } catch (\Exception $exception) {
            return '暂无数据';
        }
    }

    /**
     * 通过身份证号码解析性别
     *
     * @param $idCard
     *
     * @return string
     */
    public static function getGenderByIdCardForBlade($idCard)
    {
        if (!$idCard) {
            return '暂无数据';
        }

        try {
            $peopleIdentity = new Identity($idCard);

            if (!$peopleIdentity->legal()) {
                return '暂无数据';
            }

            return $peopleIdentity->gender();
        } catch (\Exception $exception) {
            return '暂无数据';
        }
    }

    /**
     * 获取订单分单时间
     *
     * @param $orderId
     * @param $saasAuthId
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getAssignedAt($orderId, $saasAuthId)
    {
        $personIds = SaasPersonFactory::getAllPersonBySaasId($saasAuthId);

        return SaasOrderFactory::getAssignedAtByOrderIdAndPersonIds($orderId, $personIds);
    }
}
