<?php

namespace App\Models\Factory\Admin\Order;

use App\Models\Orm\UserOrderBasicInfo;
use App\Models\Orm\UserReport;

class ReportFactory
{
    /**
     * 通过report_id获取报告用户信息
     * @param $reportId
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public static function getUserInfoById($reportId)
    {
        return UserReport::whereKey($reportId)->select([
            'id',
            'name',
            'mobile',
            'id_card',
            'location',
            'address',
            'contacts'
        ])->first();
    }

    /**
     * 通过report_id获取报告用户basicInfo表数据
     *
     * @param $reportId
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public static function getUserBasicInfoByReportId($reportId)
    {
        $query = new UserReport();
        $reportInfoId = $query->where(['id'=>$reportId])
            ->value('basic_info_id');

        $query = new UserOrderBasicInfo();
        $basicInfo = $query->where('id', $reportInfoId)->first();

        return $basicInfo;
    }
}
