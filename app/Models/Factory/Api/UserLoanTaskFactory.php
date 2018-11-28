<?php

namespace App\Models\Factory\Api;

use App\Models\Orm\UserLoanTask;

/**
 * Class UserLoanTaskFactory
 * @package App\Models\Factory\Api
 * 推送任务工厂
 */
class UserLoanTaskFactory extends ApiFactory
{
    /**
     * 根据任务状态获取任务用户id以及创建时间
     * @param $params
     */
    public static function getTasksByTypeAndStatus($type,$status)
    {
        $data = UserLoanTask::where(['type_id' => $type,'status' => $status])->get();
        return $data ? $data->toArray() : [];
    }

    /**
     * 根据id修改订单状态
     * @param $params
     */
    public static function updateStatusById($id,$status)
    {
        return UserLoanTask::where(['id'=>$id])->update(['status'=>$status]);
    }
}
