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

    /**
     * 创建贷款推送任务
     * @param $params
     * @return bool
     */
    public static function createLoanTask($data)
    {
        $loanTaskObj = new UserLoanTask();
        $loanTaskObj->user_id = $data['user_id'];
        $loanTaskObj->type_id = $data['type_id'];
        $loanTaskObj->spread_nid = $data['spread_nid'];
        $loanTaskObj->request_data = $data['request_data'];
        $loanTaskObj->response_data = $data['response_data'];
        $loanTaskObj->status = $data['status'];
        $loanTaskObj->create_at = $data['create_at'];
        $loanTaskObj->send_at = $data['send_at'];
        $loanTaskObj->update_at = $data['update_at'];

        if ($loanTaskObj->save()) {
            return $loanTaskObj->toArray();
        }

        return false;
    }
}
