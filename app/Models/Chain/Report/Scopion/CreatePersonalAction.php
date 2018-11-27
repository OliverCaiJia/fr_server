<?php

namespace App\Models\Chain\Report\Scopion;

use App\Constants\OrderConstant;
use App\Helpers\Utils;
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

    public function handleRequest()
    {
        if ($this->createPersonal($this->params)) {
            $this->setSuccessor(new UpdateUserInfoStatusAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }

//        $result = UserOrderFactory::createOrderReport($this->params);
//        if ($result) {
//            return true;
//        }
//        return $this->error;
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
//) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT=



//        $this->params['personal_idcard'] = $params['cred
//$this->params['personal_idcard_location'] = $par
//$this->params['personal_mobile'] = $params['cred
//$this->params['personal_carrier'] = $params['cre
//$this->params['personal_mobile_location'] = $par
//$this->params['personal_name'] = $params['credit
//$this->params['personal_age'] = $params['credit_
//$this->params['personal_gender'] = $params['cred
//$this->params['personal_email'] = $params['credi
//$this->params['personal_education'] = $params['c
//$this->params['personal_is_graduation'] = (int)$para

//        $para = $this->params;

        $data['user_id'] = $params['user_id'];//
        $data['idcard'] = $params['personal_idcard'];//oooo
        $data['idcard_location'] = $params['personal_idcard_location'];//oooo
        $data['mobile'] = $params['personal_mobile'];//oooo
        $data['carrier'] = $params['personal_carrier'];//
        $data['mobile_location'] = $params['personal_mobile_location'];//
        $data['name'] = $params['personal_name'];//
        $data['age'] = $params['personal_age'];//
        $data['gender'] = $params['personal_gender'];//
        $data['email'] = $params['personal_email'];//
        $data['education'] = $params['personal_education'];//
        $data['is_graduation'] = $params['personal_is_graduation'];//oooo
        $data['create_at'] = date('Y-m-d H:i:s', time());
        $data['create_ip'] = Utils::ipAddress();
        $data['update_at'] = date('Y-m-d H:i:s', time());
        $data['update_ip'] = Utils::ipAddress();

//        dd($data);
//        array:16 [▼
//  "user_id" => 6
//  "idcard" => "61030319791111****"
//  "idcard_location" => "陕西省/宝鸡市/金台区"
//  "mobile" => "1381056****"
//  "carrier" => "中国移动"
//  "mobile_location" => "北京/北京"
//  "name" => "巨*"
//  "age" => 39
//  "gender" => "男"
//  "email" => ""
//  "education" => 0
//  "is_graduation" => 0
//  "create_at" => "2018-11-22 15:03:17"
//  "create_ip" => "127.0.0.1"
//  "update_at" => "2018-11-22 15:03:17"
//  "update_ip" => "127.0.0.1"
//]

        $result = UserOrderFactory::createPersonal($data);

        if ($result) {
            return $result;
        }
        return $this->error;
    }

//    private function createPersonal($params)
//    {
////        CREATE TABLE `sgd_user_personal` (
////    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
////  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
////  `idcard` varchar(18) NOT NULL DEFAULT '' COMMENT '身份证号',
////  `idcard_location` varchar(128) NOT NULL DEFAULT '' COMMENT '身份证归属地',
////  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号',
////  `carrier` varchar(64) NOT NULL DEFAULT '' COMMENT '手机运营商',
////  `mobile_location` varchar(64) NOT NULL DEFAULT '' COMMENT '手机号归属地',
////  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '姓名',
////  `age` int(4) NOT NULL COMMENT '年龄',
////  `gender` tinyint(1) NOT NULL COMMENT '性别',
////  `email` varchar(128) NOT NULL DEFAULT '' COMMENT '邮箱',
////  `education` tinyint(4) NOT NULL COMMENT '学历',
////  `is_graduation` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否毕业',
////  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
////  `create_ip` varchar(32) NOT NULL DEFAULT '' COMMENT '创建IP',
////  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
////  `update_ip` varchar(32) NOT NULL DEFAULT '' COMMENT '更新IP',
////  PRIMARY KEY (`id`),
////  KEY `FK_USER_PERSONAL_INFO_USER_ID` (`user_id`),
////  CONSTRAINT `FK_USER_PERSONAL_INFO_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `sgd_user_auth` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
////) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT=
//
//
//
////        $this->params['personal_idcard'] = $params['cred
////$this->params['personal_idcard_location'] = $par
////$this->params['personal_mobile'] = $params['cred
////$this->params['personal_carrier'] = $params['cre
////$this->params['personal_mobile_location'] = $par
////$this->params['personal_name'] = $params['credit
////$this->params['personal_age'] = $params['credit_
////$this->params['personal_gender'] = $params['cred
////$this->params['personal_email'] = $params['credi
////$this->params['personal_education'] = $params['c
////$this->params['personal_is_graduation'] = (int)$para
//
//
//
//        $data['user_id'] = $params['user_id'];//
//        $data['idcard'] = $params['personal_idcard'];//oooo
//        $data['idcard_location'] = $params['personal_idcard_location'];//oooo
//        $data['mobile'] = $params['personal_mobile'];//oooo
//        $data['carrier'] = $params['personal_carrier'];//
//        $data['mobile_location'] = $params['personal_mobile_location'];//
//        $data['name'] = $params['personal_name'];//
//        $data['age'] = $params['personal_age'];//
//        $data['gender'] = $params['personal_gender'];//
//        $data['email'] = $params['personal_email'];//
//        $data['education'] = $params['personal_education'];//
//        $data['is_graduation'] = $params['personal_is_graduation'];//oooo
//        $data['create_at'] = date('Y-m-d H:i:s', time());
//        $data['create_ip'] = Utils::ipAddress();
//        $data['update_at'] = date('Y-m-d H:i:s', time());
//        $data['update_ip'] = Utils::ipAddress();
//
//        $userReportLog = UserOrderFactory::createPersonal($data);
//
////        $userId = $params['user_id'];
////        $orderType = $params['order_type'];
////        $userOrder = UserOrderFactory::getUserOrderByUserIdAndOrderType($userId, $orderType);
////
//        if (!$userReportLog) {
//            $this->error['error'] = "您好，报告记录关系异常！";
//            return false;
//        }
//        return $userReportLog;
//    }
}
