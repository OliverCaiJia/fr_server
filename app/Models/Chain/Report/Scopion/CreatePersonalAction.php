<?php

namespace App\Models\Chain\Report\Scopion;

use App\Constants\OrderConstant;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;

class CreatePersonalAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '订单状态不合法，审核（拒绝）失败！', 'code' => 8210];

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     *
     *
     * @return array
     */
    public function handleRequest()
    {
//        if ($this->createReportLog($this->params)) {
//            $this->setSuccessor(new CreatePersonalAction($this->params));
//            return $this->getSuccessor()->handleRequest();
//        } else {
//            return $this->error;
//        }

        $result = UserOrderFactory::createOrderReport($this->params);
        if ($result) {
            return true;
        }
        return $this->error;
    }

    private function createPersonal($params)
    {
//        CREATE TABLE `sgd_user_personal` (
//    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
//  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
//  `idcard` varchar(18) NOT NULL DEFAULT '' COMMENT '身份证号',
//  `idcard_location` varchar(128) NOT NULL DEFAULT '' COMMENT '身份证归属地',
//  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号',
//  `carrier` varchar(64) NOT NULL DEFAULT '' COMMENT '手机运营商',
//  `mobile_location` varchar(64) NOT NULL DEFAULT '' COMMENT '手机号归属地',
//  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '姓名',
//  `age` int(4) NOT NULL COMMENT '年龄',
//  `gender` tinyint(1) NOT NULL COMMENT '性别',
//  `email` varchar(128) NOT NULL DEFAULT '' COMMENT '邮箱',
//  `education` tinyint(4) NOT NULL COMMENT '学历',
//  `is_graduation` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否毕业',
//  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
//  `create_ip` varchar(32) NOT NULL DEFAULT '' COMMENT '创建IP',
//  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
//  `update_ip` varchar(32) NOT NULL DEFAULT '' COMMENT '更新IP',
//  PRIMARY KEY (`id`),
//  KEY `FK_USER_PERSONAL_INFO_USER_ID` (`user_id`),
//  CONSTRAINT `FK_USER_PERSONAL_INFO_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `sgd_user_auth` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
//) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='信息查询返回个人信息数据'
        $data['user_id'] = $params['user_id'];
        $data['idcard'] = $params['idcard'];
        $data['idcard_location'] = $params['idcard_location'];
        $data['mobile'] = $params['mobile'];
        $data['carrier'] = $params['carrier'];
        $data['mobile_location'] = $params['mobile_location'];
        $data['name'] = $params['name'];
        $data['age'] = $params['age'];
        $data['gender'] = $params['gender'];
        $data['email'] = $params['email'];
        $data['education'] = $params['education'];
        $data['is_graduation'] = $params['is_graduation'];
        $data['create_at'] = $params['create_at'];
        $data['create_ip'] = $params['create_ip'];
        $data['update_at'] = $params['update_at'];
        $data['update_ip'] = $params['update_ip'];

        $userReportLog = UserOrderFactory::createPersonal($data);

//        $userId = $params['user_id'];
//        $orderType = $params['order_type'];
//        $userOrder = UserOrderFactory::getUserOrderByUserIdAndOrderType($userId, $orderType);
//
        if (!$userReportLog) {
            $this->error['error'] = "您好，报告记录关系异常！";
            return false;
        }
        return true;
    }
}
