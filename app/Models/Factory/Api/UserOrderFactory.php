<?php

namespace App\Models\Factory\Api;

use App\Constants\UserVipConstant;
use App\Models\Orm\Platform;
use App\Models\Orm\UserAmountEst;
use App\Models\Orm\UserAntifraud;
use App\Models\Orm\UserApply;
use App\Models\Orm\UserApplyLog;
use App\Models\Orm\UserBlacklist;
use App\Models\Orm\UserLoanLog;
use App\Models\Orm\UserMultiinfo;
use App\Models\Orm\UserOrder;
use App\Models\Orm\UserOrderPlatform;
use App\Models\Orm\UserOrderReport;
use App\Models\Orm\UserOrderType;
use App\Models\Orm\UserPersonal;
use App\Models\Orm\UserPostloan;
use App\Models\Orm\UserReport;
use App\Models\Orm\UserReportLog;
use App\Models\Orm\UserReportType;

/**
 * Class UserOrderFactory
 * @package App\Models\Factory\Api
 */
class UserOrderFactory extends ApiFactory
{
    /**
     * 创建订单
     * @param $params
     * @return bool
     */
    public static function createOrder($params)
    {
        $userOrderObj = new UserOrder();
        $userOrderObj->user_id = $params['user_id'];
        $userOrderObj->order_no = $params['order_no'];
        $userOrderObj->order_type = $params['order_type'];
        $userOrderObj->p_order_id = $params['p_order_id'];
        $userOrderObj->order_expired = $params['order_expired'];//读配置
        $userOrderObj->amount = $params['amount'];
        $userOrderObj->term = $params['term'];
        $userOrderObj->count = $params['count'];
        $userOrderObj->status = $params['status'];
        $userOrderObj->create_ip = $params['create_ip'];
        $userOrderObj->create_at = $params['create_at'];
        $userOrderObj->update_ip = $params['update_ip'];
        $userOrderObj->update_at = $params['update_at'];

        if ($userOrderObj->save()) {
            return $userOrderObj->toArray();
        }

        return false;
    }

    /**
     * 创建反欺诈
     * @param $params
     * @return array|bool
     */
    public static function createAntifraud($params)
    {
//        dd($params);
//        array:12 [▼
//  "user_id" => 6
//  "user_report_id" => 17
//  "courtcase_cnt" => 0
//  "dishonest_cnt" => 0
//  "fraudulence_is_hit" => false
//  "untrusted_info" => "{"courtcase_cnt":0,"dishonest_cnt":0,"dishonest_detail_info":[]}"
//  "suspicious_idcard" => "{"other_names_cnt":0,"other_mobiles_cnt":0,"other_mobiles_black_cnt":0,"information_sources_cnt":0,"other_names":[],"other_mobiles":[],"information_sources":[]}"
//  "suspicious_mobile" => "{"other_names_cnt":0,"other_idcards_cnt":0,"other_idcards_black_cnt":0,"information_sources_cnt":0,"other_names":[],"other_idcards":[],"information_sources":[]}"
//  "data" => "{"trans_id":"dcc509e0-ecb0-11e8-9c98-00163e0ed28c","person_info":{"idcard":"61030319791111****","idcard_location":"\u9655\u897f\u7701\/\u5b9d\u9e21\u5e02\/\u91d ▶"
//  "fee" => "Y"
//  "create_at" => "2018-11-20 18:41:40"
//  "update_at" => "2018-11-20 18:41:40"
//]


//
//
//        array:12 [▼
//  "user_id" => 6
//  "user_report_id" => 25
//  "courtcase_cnt" => 0
//  "dishonest_cnt" => 0
//  "fraudulence_is_hit" => 0
//  "untrusted_info" => "{"courtcase_cnt":0,"dishonest_cnt":0,"dishonest_detail_info":[]}"
//  "suspicious_idcard" => "{"other_names_cnt":0,"other_mobiles_cnt":0,"other_mobiles_black_cnt":0,"information_sources_cnt":0,"other_names":[],"other_mobiles":[],"information_sources":[]}"
//  "suspicious_mobile" => "{"other_names_cnt":0,"other_idcards_cnt":0,"other_idcards_black_cnt":0,"information_sources_cnt":0,"other_names":[],"other_idcards":[],"information_sources":[]}"
//  "data" => "{"trans_id":"99bd3d50-ecb2-11e8-9c98-00163e0ed28c","person_info":{"idcard":"61030319791111****","idcard_location":"\u9655\u897f\u7701\/\u5b9d\u9e21\u5e02\/\u91d ▶"
//  "fee" => "Y"
//  "create_at" => "2018-11-20 18:54:07"
//  "update_at" => "2018-11-20 18:54:07"
//]
//
//



//        CREATE TABLE `sgd_user_antifraud` (
//    `id` int(11) NOT NULL COMMENT 'id',
//  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
//  `user_report_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'user_reports表的id',
//  `courtcase_cnt` int(11) NOT NULL COMMENT '法院执行次数',
//  `dishonest_cnt` int(11) NOT NULL COMMENT '失信未执行次数',
//  `fraudulence_is_hit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '欺诈名单是否命中',
//  `untrusted_info` json NOT NULL COMMENT '失信信息',
//  `suspicious_idcard` json NOT NULL COMMENT '身份存疑',
//  `suspicious_mobile` json NOT NULL COMMENT '手机存疑',
//  `data` json NOT NULL COMMENT '设备存疑',
//  `fee` varchar(255) NOT NULL DEFAULT '' COMMENT '费用',
//  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
//  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
//  PRIMARY KEY (`id`),
//  UNIQUE KEY `FK_USER_ANTIFRAUD_USER_ID` (`user_id`) USING BTREE,
//  CONSTRAINT `FK_USER_ANTIFRAUD_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `sgd_user_auth` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
//) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户反欺诈信息表'

//        CREATE TABLE `sgd_user_antifraud` (
//    `id` int(11) NOT NULL COMMENT 'id',
//  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
//  `user_report_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'user_reports表的id',
//  `courtcase_cnt` int(11) NOT NULL COMMENT '法院执行次数',
//  `dishonest_cnt` int(11) NOT NULL COMMENT '失信未执行次数',
//  `fraudulence_is_hit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '欺诈名单是否命中',
//  `untrusted_info` json NOT NULL COMMENT '失信信息',
//  `suspicious_idcard` json NOT NULL COMMENT '身份存疑',
//  `suspicious_mobile` json NOT NULL COMMENT '手机存疑',
//  `data` json NOT NULL COMMENT '设备存疑',
//  `fee` varchar(255) NOT NULL DEFAULT '' COMMENT '费用',
//  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
//  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
//  PRIMARY KEY (`id`),
//  UNIQUE KEY `FK_USER_ANTIFRAUD_USER_ID` (`user_id`) USING BTREE,
//  CONSTRAINT `FK_USER_ANTIFRAUD_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `sgd_user_auth` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
//) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户反欺诈信息表'
        $userAntifraud = new UserAntifraud();
        $userAntifraud->user_id = $params['user_id'];
        $userAntifraud->user_report_id = $params['user_report_id'];
        $userAntifraud->courtcase_cnt = $params['courtcase_cnt'];
        $userAntifraud->dishonest_cnt = $params['dishonest_cnt'];
        $userAntifraud->fraudulence_is_hit = $params['fraudulence_is_hit'];
        $userAntifraud->untrusted_info = $params['untrusted_info'];
        $userAntifraud->suspicious_idcard = $params['suspicious_idcard'];
        $userAntifraud->suspicious_mobile = $params['suspicious_mobile'];
        $userAntifraud->data = $params['data'];
        $userAntifraud->fee = $params['fee'];
        $userAntifraud->create_at = $params['create_at'];
        $userAntifraud->update_at = $params['update_at'];
//dd($params);
//        array:12 [▼
//  "user_id" => 6
//  "user_report_id" => 1
//  "courtcase_cnt" =>
//  "dishonest_cnt" => 0
//  "fraudulence_is_hit" => 0
//  "untrusted_info" => "{"people":[{"firstName":"Brett","lastName":"McLaughlin","email":"aaaa"},{"firstName":"Jason","lastName":"Hunter","email":"bbbb"},{"firstName":"Elliotte","lastNa ▶"
//  "suspicious_idcard" => "{"people":[{"firstName":"Brett","lastName":"McLaughlin","email":"aaaa"},{"firstName":"Jason","lastName":"Hunter","email":"bbbb"},{"firstName":"Elliotte","lastNa ▶"
//  "suspicious_mobile" => "{"people":[{"firstName":"Brett","lastName":"McLaughlin","email":"aaaa"},{"firstName":"Jason","lastName":"Hunter","email":"bbbb"},{"firstName":"Elliotte","lastNa ▶"
//  "data" => "{"people":[{"firstName":"Brett","lastName":"McLaughlin","email":"aaaa"},{"firstName":"Jason","lastName":"Hunter","email":"bbbb"},{"firstName":"Elliotte","lastNa ▶"
//  "fee" => "Y"
//  "create_at" => "2018-11-21 13:28:26"
//  "update_at" => "2018-11-21 13:28:26"
//]


        if ($userAntifraud->save()) {
            return $userAntifraud->toArray();
        }

        return false;
    }

    /**
     * 创建报告日志
     * @param $params
     * @return array|bool
     */
    public static function createReportLog($params)
    {
//        CREATE TABLE `sgd_user_report_log` (
//    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
//  `user_report_type_id` int(11) unsigned NOT NULL COMMENT '报告类型id',
//  `user_id` int(11) NOT NULL COMMENT '用户id',
//  `order_id` int(11) NOT NULL COMMENT '订单id',
//  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '报告状态 0待支付 1支付完成 2报告完成',
//  `data` json NOT NULL COMMENT '报告返回数据',
//  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
//  `create_ip` varchar(16) NOT NULL DEFAULT '' COMMENT '创建IP',
//  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
//  `update_ip` varchar(16) NOT NULL DEFAULT '' COMMENT '更新IP',
//  PRIMARY KEY (`id`)
//) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COMMENT='用户报告日志表（单次请求）'
        $userReportLog = new UserReportLog();
        $userReportLog->user_id = $params['user_id'];
        $userReportLog->user_report_type_id = $params['user_report_type_id'];
        $userReportLog->order_id = $params['order_id'];


        $userReportLog->status = $params['status'];
        $userReportLog->data = $params['data'];
        $userReportLog->create_at = $params['create_at'];
        $userReportLog->create_ip = $params['create_ip'];
        $userReportLog->update_at = $params['update_at'];
        $userReportLog->update_ip = $params['update_ip'];
//        array:9 [▼
//  "user_report_type_id" => 1
//  "user_id" => 6
//  "order_id" => 91
//  "status" => 1
//  "data" => ""
//  "create_at" => "2018-11-21 10:27:59"
//  "create_ip" => "127.0.0.1"
//  "update_at" => "2018-11-21 10:27:59"
//  "update_ip" => "127.0.0.1"
//]
        if ($userReportLog->save()) {
            return $userReportLog->toArray();
        }

        return false;
    }

    /**
     * 创建报告
     * @param $params
     * @return array|bool
     */
    public static function createReport($params)
    {
//        CREATE TABLE `sgd_user_report` (
//    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
//  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
//  `report_code` varchar(128) NOT NULL DEFAULT '' COMMENT '报告编号',
//  `report_data` json NOT NULL COMMENT '报告数据',
//  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
//  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
//  PRIMARY KEY (`id`),
//  UNIQUE KEY `FK_USER_REPORT_USER_ID` (`user_id`) USING BTREE,
//  CONSTRAINT `FK_USER_REPORT_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `sgd_user_auth` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
//) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户报告信息表'

//        array:5 [▼
//  "user_id" => 6
//  "report_code" => "RSGD-A-20181120182442-512691"
//  "report_data" => array:6 [▶]
//  "create_at" => "2018-11-20 18:24:42"
//  "update_at" => "2018-11-20 18:24:42"
//]
        $userReport = new UserReport();
        $userReport->user_id = $params['user_id'];
        $userReport->report_code = $params['report_code'];
        $userReport->report_data = $params['report_data'];
        $userReport->create_at = $params['create_at'];
        $userReport->update_at = $params['update_at'];

        if ($userReport->save()) {
            return $userReport->toArray();
        }
        return false;
    }

    /**
     * 创建申请
     * @param $params
     * @return array|bool
     */
    public static function createApply($params)
    {
//        CREATE TABLE `sgd_user_apply` (
//    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
//  `user_id` int(11) unsigned DEFAULT NULL COMMENT '用户id',
//  `user_report_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关联的jt_user_reports表的id',
//  `transid` varchar(128) NOT NULL DEFAULT '' COMMENT '传输id',
//  `data` json NOT NULL,
//  `fee` varchar(255) NOT NULL DEFAULT '' COMMENT '收费',
//  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
//  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
//  PRIMARY KEY (`id`),
//  UNIQUE KEY `FK_USER_APPLYIN_USER_ID` (`user_id`) USING BTREE,
//  CONSTRAINT `FK_USER_APPLYIN_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `sgd_user_auth` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
//) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COMMENT='用户注入信息表'
//        array:7 [▼
//  "user_id" => 6
//  "user_report_id" => 137
//  "transid" => "e2481f00-ee28-11e8-9d68-00163e0d2aee"
//  "data" => "{"trans_id":"e2481f00-ee28-11e8-9d68-00163e0d2aee","person_info":{"idcard":"21092219891006****","idcard_location":"\u8fbd\u5b81\u7701\/\u961c\u65b0\u5e02\/\u5f7 ▶"
//  "fee" => "Y"
//  "create_at" => "2018-11-22 15:33:22"
//  "update_at" => "2018-11-22 15:33:22"
//]
        $userApply = new UserApply();
        $userApply->user_id = $params['user_id'];
        $userApply->user_report_id = $params['user_report_id'];
        $userApply->transid = $params['transid'];
//        $userApply->due_days_non_cdq_12_mon = $params['due_days_non_cdq_12_mon'];
//        $userApply->pay_cnt_12_mon = $params['pay_cnt_12_mon'];
//        $userApply->loan_behavior_analysis = $params['loan_behavior_analysis'];//读配置
        $userApply->data = $params['data'];
        $userApply->fee = $params['fee'];
        $userApply->create_at = $params['create_at'];
        $userApply->update_at = $params['update_at'];

        if ($userApply->save()) {
            return $userApply->toArray();
        }

        return false;
    }

    /**
     * 创建用户电商额度数据
     * @param $params
     * @return array|bool
     */
    public static function createAmountEst($params)
    {

//        CREATE TABLE `sgd_user_amount_est` (
//    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
//  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
//  `user_report_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关联的user_reports表的id',
//  `zm_score` int(8) NOT NULL DEFAULT '0' COMMENT '芝麻分',
//  `huabai_limit` int(8) NOT NULL DEFAULT '0' COMMENT '花呗额度',
//  `credit_amt` int(8) NOT NULL DEFAULT '0' COMMENT '借呗额度',
//  `data` json NOT NULL COMMENT '返回数据',
//  `fee` varchar(255) NOT NULL DEFAULT '' COMMENT '是否收费',
//  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
//  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
//  PRIMARY KEY (`id`),
//  KEY `FK_USER_MULTIINFO_USER_ID` (`user_id`),
//  CONSTRAINT `sgd_user_amount_est_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `sgd_user_auth` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
//) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户电商额度数据表'
        $userAmountEst = new UserAmountEst();
        $userAmountEst->user_id = $params['user_id'];
        $userAmountEst->user_report_id = $params['user_report_id'];
        $userAmountEst->zm_score = $params['zm_score'];
        $userAmountEst->huabai_limit = $params['huabai_limit'];
        $userAmountEst->credit_amt = $params['credit_amt'];
        $userAmountEst->data = $params['data'];
        $userAmountEst->fee = $params['fee'];
        $userAmountEst->create_at = $params['create_at'];
        $userAmountEst->update_at = $params['update_at'];

        if ($userAmountEst->save()) {
            return $userAmountEst->toArray();
        }

        return false;
    }

    public static function createPostloan($params)
    {
//        CREATE TABLE `sgd_user_postloan` (
//    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
//  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
//  `user_report_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关联的jt_user_reports表的id',
//  `transid` varchar(128) NOT NULL DEFAULT '' COMMENT '传输id',
//  `due_days_non_cdq_12_mon` int(8) NOT NULL COMMENT '近12个月最近一次非超短期现金贷逾期距今天数(',
//  `pay_cnt_12_mon` int(8) NOT NULL DEFAULT '0' COMMENT '近12个月累计还款笔数',
//  `data` json NOT NULL COMMENT '贷后行为',
//  `fee` varchar(255) NOT NULL DEFAULT '',
//  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
//  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
//  PRIMARY KEY (`id`),
//  KEY `FK_USER_POSTLOAN_USER_ID` (`user_id`),
//  CONSTRAINT `FK_USER_POSTLOAN_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `sgd_user_auth` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
//) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户贷后数据表'
        $userPostloan = new UserPostloan();
        $userPostloan->user_id = $params['user_id'];
        $userPostloan->user_report_id = $params['user_report_id'];
        $userPostloan->transid = $params['transid'];
        $userPostloan->due_days_non_cdq_12_mon = $params['due_days_non_cdq_12_mon'];
        $userPostloan->pay_cnt_12_mon = $params['pay_cnt_12_mon'];
        $userPostloan->data = $params['data'];
        $userPostloan->fee = $params['fee'];
        $userPostloan->create_at = $params['create_at'];
        $userPostloan->update_at = $params['update_at'];

        if ($userPostloan->save()) {
            return $userPostloan->toArray();
        }

        return false;
    }

    /**
     * 创建黑名单
     * @param $params
     * @return array|bool
     */
    public static function createBlackList($params)
    {
//        CREATE TABLE `sgd_user_blacklist` (
//    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
//  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
//  `user_report_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关联的user_reports表的id',
//  `transid` varchar(128) NOT NULL DEFAULT '' COMMENT '传输id',
//  `mobile_name_in_blacklist` tinyint(1) NOT NULL DEFAULT '0' COMMENT '姓名手机是否在黑名单',
//  `idcard_name_in_blacklist` tinyint(1) NOT NULL DEFAULT '0' COMMENT '身份证和姓名是否在黑名单',
//  `black_info_detail` json NOT NULL COMMENT '黑名单信息',
//  `gray_info_detail` json NOT NULL COMMENT '灰名单信息',
//  `data` json NOT NULL COMMENT '数据',
//  `fee` varchar(32) NOT NULL DEFAULT '' COMMENT '是否收费',
//  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
//  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
//  PRIMARY KEY (`id`),
//  KEY `FK_USER_BLACKLIST_USER_ID` (`user_id`),
//  CONSTRAINT `FK_USER_BLACKLIST_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `sgd_user_auth` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
//) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        $userBlacklist = new UserBlacklist();
        $userBlacklist->user_id = $params['user_id'];
        $userBlacklist->user_report_id = $params['user_report_id'];
        $userBlacklist->transid = $params['transid'];
        $userBlacklist->mobile_name_in_blacklist = $params['mobile_name_in_blacklist'];
        $userBlacklist->idcard_name_in_blacklist = $params['idcard_name_in_blacklist'];
        $userBlacklist->black_info_detail = $params['black_info_detail'];
        $userBlacklist->gray_info_detail = $params['gray_info_detail'];
        $userBlacklist->data = $params['data'];
        $userBlacklist->fee = $params['fee'];
        $userBlacklist->create_at = $params['create_at'];
        $userBlacklist->update_at = $params['update_at'];
        if ($userBlacklist->save()) {
            return $userBlacklist->toArray();
        }
        return false;
    }

    /**
     * 创建多头
     * @param $params
     * @return array|bool
     */
    public static function createMultiinfo($params)
    {
//        CREATE TABLE `sgd_user_multiinfo` (
//    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
//  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
//  `user_report_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关联的user_reports表的id',
//  `register_org_count` int(8) NOT NULL DEFAULT '0' COMMENT '注册机构数量',
//  `loan_cnt` int(8) NOT NULL DEFAULT '0' COMMENT '借贷次数',
//  `loan_org_cnt` int(8) NOT NULL DEFAULT '0' COMMENT '借贷机构数',
//  `transid` varchar(128) NOT NULL DEFAULT '' COMMENT '传输id',
//  `data` json NOT NULL,
//  `fee` varchar(255) NOT NULL DEFAULT '',
//  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
//  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
//  PRIMARY KEY (`id`),
//  KEY `FK_USER_MULTIINFO_USER_ID` (`user_id`),
//  CONSTRAINT `FK_USER_MULTIINFO_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `sgd_user_auth` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
//) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户多头数据表'
        $userMultiinfo = new UserMultiinfo();
        $userMultiinfo->user_id = $params['user_id'];
        $userMultiinfo->user_report_id = $params['user_report_id'];
        $userMultiinfo->register_org_count = $params['register_org_count'];
        $userMultiinfo->loan_cnt = $params['loan_cnt'];
        $userMultiinfo->loan_org_cnt = $params['loan_org_cnt'];
        $userMultiinfo->transid = $params['transid'];
        $userMultiinfo->data = $params['data'];
        $userMultiinfo->fee = $params['fee'];
        $userMultiinfo->create_at = $params['create_at'];
        $userMultiinfo->update_at = $params['update_at'];
        if ($userMultiinfo->save()) {
            return $userMultiinfo->toArray();
        }
        return false;
    }

    public static function createPersonal($params)
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
        $userPersonal = new UserPersonal();
        $userPersonal->user_id = $params['user_id'];
        $userPersonal->idcard = $params['idcard'];
        $userPersonal->idcard_location = $params['idcard_location'];
        $userPersonal->mobile = $params['mobile'];
        $userPersonal->carrier = $params['carrier'];
        $userPersonal->mobile_location = $params['mobile_location'];
        $userPersonal->name = $params['name'];
        $userPersonal->age = $params['age'];
        $userPersonal->gender = $params['gender'];
        $userPersonal->email = $params['email'];
        $userPersonal->education = $params['education'];
        $userPersonal->is_graduation = $params['is_graduation'];
        $userPersonal->create_at = $params['create_at'];
        $userPersonal->create_ip = $params['create_ip'];
        $userPersonal->update_at = $params['update_at'];
        $userPersonal->update_ip = $params['update_ip'];

        if ($userPersonal->save()) {
            return $userPersonal->toArray();
        }
        return false;
    }

    /**
     * 根据用户id和订单号更新订单状态
     * @param $userId
     * @param $orderNo
     * @param $status
     * @return mixed
     */
    public static function updateOrderStatusBUserIdAndOrderNo($userId, $orderNo, $status)
    {
        return UserOrder::where(['user_id' => $userId, 'order_no' => $orderNo])
            ->update(['status' => $status]);
    }

    /**
     * 根据用户id和订单号更新订单状态
     * @param $userId
     * @param $orderNo
     * @param $status
     * @return mixed
     */
    public static function updatePersonByUserIdAndOrderNo($userId, $orderNo, $status)
    {
        return UserOrder::where(['user_id' => $userId, 'order_no' => $orderNo])
            ->update(['status' => $status]);
    }

    /**
     * 根据用户id和订单号更新订单
     * @param $userId
     * @param $orderNo
     * @param array $data
     * @return mixed
     */
    public static function updateOrderByUserIdAndOrderNo($userId, $orderNo, $data = [])
    {
        return UserOrder::where(['user_id' => $userId, 'order_no' => $orderNo])
            ->update($data);
    }

    /**
     * 获取订单类型ID
     *
     * @param string $nid
     * @return int
     */
    public static function getOrderType($nid = UserVipConstant::ORDER_TYPE)
    {
        $id = UserOrderType::where(['type_nid' => $nid])
            ->value('id');

        return $id ? $id : 1;
    }

    /**
     * 根据订单编号和用户id获取订单
     * @param $orderNo
     * @param $userId
     * @return \Illuminate\Support\Collection
     */
    public static function getOrderDetailByOrderNoAndUserId($orderNo, $userId)
    {
        $userOrder = UserOrder::where([UserOrder::TABLE_NAME . '.order_no' => $orderNo])
            ->where([UserOrder::TABLE_NAME . '.user_id' => $userId])
//            ->leftJoin(Platform::TABLE_NAME, UserOrder::TABLE_NAME . '.platform_nid', '=', Platform::TABLE_NAME . '.platform_nid')
            ->get();

        return $userOrder ? $userOrder->toArray() : [];
    }

    /**
     * 根据订单编号和用户id获取订单详情
     * @param $orderNo
     * @param $userId
     * @return array
     */
    public static function getOrderDetailWithPlatformByOrderNoAndUserId($orderNo, $userId)
    {
        $userOrder = UserOrder::where([UserOrder::TABLE_NAME . '.order_no' => $orderNo])
            ->where([UserOrder::TABLE_NAME . '.user_id' => $userId])
            ->leftJoin(Platform::TABLE_NAME, UserOrder::TABLE_NAME . '.platform_nid', '=', Platform::TABLE_NAME . '.platform_nid')
            ->get();

        return $userOrder ? $userOrder->toArray() : [];
    }

    /**
     * 根据订单编号获取订单详情
     * @param $orderNo
     * @return array
     */
    public static function getOrderDetailByOrderNo($orderNo)
    {
        $userOrder = UserOrder::where([UserOrder::TABLE_NAME . '.order_no' => $orderNo])
            ->get();
        return $userOrder ? $userOrder->toArray() : [];
    }

    /**
     * 根据用户id获取订单列表
     * @param $userId
     * @return mixed
     */
    public static function getOrderByUserId($userId)
    {
        $userOrder = UserOrder::select()
            ->where('user_id', '=', $userId)
            ->get();
        return $userOrder ? $userOrder->toArray() : [];
    }

    /**
     * 根据用户id获取订单列表(包含logo）
     * @param $userId
     * @return array
     */
    public static function getOrderAndTypeLogoByUserId($userId)
    {
        $userOrder = UserOrder::where([UserOrder::TABLE_NAME . '.user_id' => $userId])
            ->leftJoin(UserOrderType::TABLE_NAME, UserOrder::TABLE_NAME . '.order_type', '=', UserOrderType::TABLE_NAME . '.id')
            ->get();
        return $userOrder ? $userOrder->toArray() : [];
    }

    /**
     * 根据用户id和订单号获取订单
     * @param $userId
     * @param $orderNo
     * @return mixed
     */
    public static function getOrderByUserIdOrderNo($userId, $orderNo)
    {
        $userOrder = UserOrder::select()
            ->where('user_id', '=', $userId)
            ->where('order_no', '=', $orderNo)
            ->first();
        return $userOrder ? $userOrder->toArray() : [];
    }

    /**
     * 根据用户id和订单号获取订单详情（含平台信息）
     * @param $userId
     * @param $orderNo
     * @return array
     */
    public static function getOrderPlatformByUserIdAndOrderNo($userId, $orderNo)
    {
        $userOrder = UserOrder::where([UserOrder::TABLE_NAME . '.user_id' => $userId])
            ->where([UserOrder::TABLE_NAME . '.order_no' => $orderNo])
            ->leftJoin(UserOrderPlatform::TABLE_NAME, UserOrder::TABLE_NAME . '.id', '=', UserOrderPlatform::TABLE_NAME . '.order_id')
            ->get();
        return $userOrder ? $userOrder->toArray() : [];
    }

    /**
     * 根据订单类型唯一标识获取订单类型
     * @param $typeNid
     * @return array
     */
    public static function getOrderTypeByTypeNid($typeNid)
    {
        $userOrder = UserOrderType::select()
            ->where('type_nid', '=', $typeNid)
            ->where('status', '=', 1)//TODO::CONSTANT
            ->first();
        return $userOrder ? $userOrder->toArray() : [];
    }

    /**
     * 根据订单id获取订单唯一标识
     * @param $typeId
     * @return array
     */
    public static function getOrderTypeNidByTypeId($typeId)
    {
        $userOrder = UserOrderType::select()
            ->where('id', '=', $typeId)
            ->where('status', '=', 1)//TODO::CONSTANT
            ->first();
        return $userOrder ? $userOrder->toArray() : [];
    }


    /**
     * 根据订单id获取订单类型
     * @param $id
     * @return array
     */
    public static function getOrderTypeById($id)
    {
        $userOrder = UserOrderType::select()
            ->where('id', '=', $id)
            ->where('status', '=', 1)//TODO::CONSTANT
            ->first();
        return $userOrder ? $userOrder->toArray() : [];
    }

    /**
     * 通过用户id和订单类型获取用户订单
     * @param $userId
     * @param $orderType
     * @return array
     */
    public static function getUserOrderByUserIdAndOrderType($userId, $orderType)
    {
        $userOrder = UserOrder::select()
            ->where('user_id', '=', $userId)
            ->where('order_type', '=', $orderType)
            ->first();
        return $userOrder ? $userOrder->toArray() : [];
    }

    /**
     * 根据用户id和订单id检查订单是否支付
     * @param $userId
     * @param $orderId
     * @return array
     */
    public static function getUserOrderByUserIdAndOrderId($userId, $orderId)
    {
        $userOrder = UserOrder::select()
            ->where('id', '=', $orderId)
            ->where('user_id', '=', $userId)
            ->first();
        return $userOrder ? $userOrder->toArray() : [];
    }

    /**
     * 通过用户id和订单编号获取用户订单
     * @param $userId
     * @param $orderNo
     * @return array
     */
    public static function getUserOrderByUserIdAndOrderNo($userId, $orderNo)
    {
        $userOrder = UserOrder::select()
            ->where('user_id', '=', $userId)
            ->where('order_no', '=', $orderNo)
            ->first();
        return $userOrder ? $userOrder->toArray() : [];
    }

    /**
     * 通过订单编号获取用户订单
     * @param $orderNo
     * @return array
     */
    public static function getUserOrderByOrderNo($orderNo)
    {
        $userOrder = UserOrder::select()
            ->where('order_no', '=', $orderNo)
            ->first();
        return $userOrder ? $userOrder->toArray() : [];
    }

    /**
     * @param $params
     * @return array|bool
     */
    public static function createUserApplyLog($params)
    {
        $userApplyLog = new UserApplyLog();
        $userApplyLog->user_id = $params['user_id'];
        $userApplyLog->product_id = $params['product_id'];
        $userApplyLog->channel_id = $params['channel_id'];
        $userApplyLog->channel_nid = $params['channel_nid'];
        $userApplyLog->channel_title = $params['channel_title'];
        $userApplyLog->create_at = date('Y-m-d H:i:s', time());
        $userApplyLog->update_at = date('Y-m-d H:i:s', time());

        if ($userApplyLog->save()) {
            return $userApplyLog->toArray();
        }
        return false;
    }

    /**
     * @param $params
     * @return array|bool
     */
    public static function createUserLoanLog($params)
    {
//        `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
//  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
//  `platform_id` int(11) unsigned NOT NULL COMMENT '平台接口id',
//  `loan_order_id` int(11) NOT NULL COMMENT '贷款申请订单id',
//  `expire_day` int(10) NOT NULL DEFAULT '0' COMMENT '失效时间',
//  `loan_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '申请金额',
//  `loan_peroid` int(8) NOT NULL DEFAULT '0' COMMENT '申请周期',
//  `request_data` json NOT NULL COMMENT '请求数据参数',
//  `response_data` json NOT NULL COMMENT '响应返回数据',
//  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
//  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
        $userLoanLog = new UserLoanLog();
        $userLoanLog->user_id = $params['user_id'];


        $userLoanLog->product_id = $params['product_id'];
        $userLoanLog->channel_id = $params['channel_id'];
        $userLoanLog->channel_nid = $params['channel_nid'];
        $userLoanLog->channel_title = $params['channel_title'];
        $userLoanLog->create_at = date('Y-m-d H:i:s', time());
        $userLoanLog->update_at = date('Y-m-d H:i:s', time());

        if ($userLoanLog->save()) {
            return $userLoanLog->toArray();
        }
        return false;
    }


    /**
     * 通过报告标识获取报告类型
     * @param $typeNid
     * @return array
     */
    public static function getUserReportTypeByTypeNid($typeNid)
    {
        $userOrder = UserReportType::select()
            ->where('report_type_nid', '=', $typeNid)
            ->where('status', '=', 1)//TODO::CONSTANT
            ->first();
        return $userOrder ? $userOrder->toArray() : [];
    }

//    /**
//     * 创建订单报告中间表
//     * @param $params
//     * @return bool
//     */
//    public static function createOrderReport($params)
//    {
//        dd($params);
//        $userOrderReport = new UserOrderReport();
//        $userOrderReport->order_id = $params['order_id'];
//        $userOrderReport->report_id = $params['report_id'];
//
//        return $userOrderReport->save();
//    }

    /**
     *创建用户报告日志
     * @param $params
     * @return bool
     */
    public static function createUserReportLog($params)
    {
        $userReportLog = new UserReportLog();
        $userReportLog->user_report_type_id = $params['user_report_type_id'];
        $userReportLog->user_id = $params['user_id'];
        $userReportLog->order_id = $params['order_id'];
        $userReportLog->status = $params['status'];
        $userReportLog->create_at = $params['create_at'];
        $userReportLog->create_ip = $params['create_ip'];
        $userReportLog->update_at = $params['update_at'];
        $userReportLog->update_ip = $params['update_ip'];

        if ($userReportLog->save()) {
            return $userReportLog->toArray();
        }
        return false;
    }

    /**
     * 更新订单编号
     * @param $params
     * @return mixed
     */
    public static function UpdateUserReportLogOrderIdById($params)
    {
        return UserReportLog::where(['id' => $params['user_report_log_id']])
            ->update(['order_id' => $params['user_order_id']]);
    }
}
