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
//        CREATE TABLE `sgd_user_loan_task` (
//    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
//  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
//  `type_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '推送类型id 0平台推送 1 内部产品推送',
//  `spread_nid` varchar(32) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '推送产品标识符【例：paipaidai】',
//  `request_data` json NOT NULL COMMENT '请求数据',
//  `response_data` json NOT NULL COMMENT '响应数据',
//  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0,未发送 1,已发送 2,成功 3,超过限额未发送 4 过期',
//  `create_at` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '创建时间',
//  `send_at` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '发送时间',
//  `update_at` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '更新时间',
//  PRIMARY KEY (`id`),
//  KEY `FK_USER_LOAN_TASK_USER_ID` (`user_id`),
//  KEY `IDX_USER_LOAN_TASK_STATUS` (`status`) USING BTREE,
//  CONSTRAINT `FK_USER_LOAN_TASK_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `sgd_user_auth` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
//) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COMMENT='贷款推送任务表'
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
