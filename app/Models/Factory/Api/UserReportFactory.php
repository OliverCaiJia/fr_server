<?php

namespace App\Models\Factory\Api;

use App\Constants\UserVipConstant;
use App\Models\Orm\UserAmountEst;
use App\Models\Orm\UserAntifraud;
use App\Models\Orm\UserApply;
use App\Models\Orm\UserApplyLog;
use App\Models\Orm\UserBlacklist;
use App\Models\Orm\UserLoanLog;
use App\Models\Orm\UserMultiinfo;
use App\Models\Orm\UserOrder;
use App\Models\Orm\UserOrderReport;
use App\Models\Orm\UserOrderType;
use App\Models\Orm\UserPersonal;
use App\Models\Orm\UserPostloan;
use App\Models\Orm\UserReport;
use App\Models\Orm\UserReportLog;
use App\Models\Orm\UserReportType;


class UserReportFactory extends ApiFactory
{
    /**
     * 根据报告类型唯一标识获取报告类型
     * @param $typeNid
     * @return array
     */
    public static function getReportTypeByTypeNid($typeNid)
    {
        $reportType = UserReportType::select()
            ->where('report_type_nid', '=', $typeNid)
            ->where('status', '=', 1)//TODO::CONSTANT
            ->first();
        return $reportType ? $reportType->toArray() : [];
    }

    /**
     * 根据用户id获取信用报告
     * @param $userId
     */
    public static function getReportByUserId($userId)
    {
        $reportData = UserReport::where(['user_id'=>$userId])->first();
        return $reportData ? $reportData->toArray() : [];
    }

    /**
     * 根据报告id获取报告订单关系
     * @param $reportId
     * @return array
     */
    public static function getReportOrderByReportId($reportId)
    {
        $reportOrder = UserOrderReport::select()
            ->where('report_id', '=', $reportId)
            ->first();
        return $reportOrder ? $reportOrder->toArray() : [];
    }
}
