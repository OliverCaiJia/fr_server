<?php

namespace App\Strategies;

use App\Helpers\Logger\SLogger;
use App\Helpers\Utils;

class ReportStrategy extends AppStrategy
{
    /**
     * 获取反欺诈信息
     * @param $params
     * @return mixed
     */
    public static function getAntifraud($params)
    {
        $antifraud['user_id'] = $params['user_id'];
        $antifraud['courtcase_cnt'] = isset($params['anti_fraud']['data']['untrusted_info']['courtcase_cnt']) ? $params['anti_fraud']['data']['untrusted_info']['courtcase_cnt'] : '';
        $antifraud['dishonest_cnt'] = isset($params['anti_fraud']['data']['untrusted_info']['dishonest_cnt']) ? $params['anti_fraud']['data']['untrusted_info']['dishonest_cnt'] : '';
        $antifraud['fraudulence_is_hit'] = intval(isset($params['anti_fraud']['data']['fraudulence_info']['is_hit'])) ? $params['anti_fraud']['data']['fraudulence_info']['is_hit'] : 0;
        $antifraud['untrusted_info'] = json_encode(isset($params['anti_fraud']['data']['untrusted_info']) ? $params['anti_fraud']['data']['untrusted_info'] : []);
        $antifraud['suspicious_idcard'] = json_encode(isset($params['anti_fraud']['data']['suspicious_idcard']) ? $params['anti_fraud']['data']['suspicious_idcard'] : []);
        $antifraud['suspicious_mobile'] = json_encode(isset($params['anti_fraud']['data']['suspicious_mobile']) ? $params['anti_fraud']['data']['suspicious_mobile'] : []);
        $antifraud['data'] = json_encode(isset($params['anti_fraud']['data']) ? $params['anti_fraud']['data'] : []);
        $antifraud['fee'] = isset($params['anti_fraud']['fee']) ? $params['anti_fraud']['fee'] : '';
        $antifraud['create_at'] = date('Y-m-d H:i:s', time());
        $antifraud['update_at'] = date('Y-m-d H:i:s', time());
        return $antifraud;
    }

    /**
     * 获取申请准入信息
     * @param $params
     * @return mixed
     */
    public static function getApply($params)
    {
        $userApply['user_id'] = $params['user_id'];
        $userApply['transid'] = $params['application']['data']['trans_id'];
        $userApply['data'] = json_encode($params['application']['data']);
        $userApply['fee'] = $params['application']['fee'];
        $userApply['create_at'] = date('Y-m-d H:i:s', time());
        $userApply['update_at'] = date('Y-m-d H:i:s', time());
        return $userApply;
    }

    /**
     * 获取额度评估(账户)
     * @param $params
     * @return mixed
     */
    public static function getEvaluation($params)
    {
        SLogger::getStream()->error('11111111111111111111111');
        SLogger::getStream()->error(json_encode($params));
        SLogger::getStream()->error('22222222222222222222222');
        //        array:5 [
//        "success" => true
//  "code" => "0000"
//  "msg" => "操作成功"
//  "data" => array:4 [
//        "trans_id" => "1f7788d0-fc79-11e8-b5a5-00163e0da63a"
//    "person_info" => array:10 [
//        "idcard" => "13070219811107****"
//      "idcard_location" => "河北省/张家口市/桥东区"
//      "mobile" => "1851053****"
//      "carrier" => "中国联通"
//      "mobile_location" => "北京/北京"
//      "name" => "蔡*"
//      "age" => 37
//      "gender" => "男"
//      "email" => ""
//      "education_info" => array:2 [
//        "level" => 0
//        "is_graduation" => false
//      ]
//    ]
//    "fund_infos" => []
//    "bank_infos" => array:2 [
//        "debit_card_info" => array:9 [
//        "update_date" => ""
//        "card_amount" => 0
//        "balance" => ""
//        "total_income" => ""
//        "total_salary_income" => ""
//        "total_loan_income" => ""
//        "total_outcome" => ""
//        "total_consume_outcome" => ""
//        "total_loan_outcome" => ""
//      ]
//      "credit_card_info" => array:7 [
//        "update_date" => ""
//        "card_amount" => 0
//        "total_credit_limit" => ""
//        "total_credit_available" => ""
//        "max_credit_limit" => ""
//        "overdue_times" => 0
//        "overdue_months" => 0
//      ]
//    ]
//  ]
//  "fee" => "N"
//]

//        if (isset($credidtEvaluation['data'])) {
//            $this->params['credit_evaluation'] = $credidtEvaluation;
//            $this->params['report_data']['credit_evaluation'] = $credidtEvaluation['data'];
//        }
        $userEvaluation['user_id'] = $params['user_id'];
//        if (isset($params['credit_evaluation']['data']['fund_infos'])) {
//            $userEvaluation['fund_money'] = $params['credit_evaluation']['data']['fund_infos']['fund_basic']['balance'];
//        }
//        CREATE TABLE `sgd_user_estimate_rep` (
//    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
//  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
//  `user_report_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关联的user_reports表的id',
//  `fund_money` decimal(15,2) NOT NULL COMMENT '公积金余额',
//  `year_income` decimal(15,2) NOT NULL COMMENT '年收入',
//  `year_salary` decimal(15,2) NOT NULL COMMENT '年工资',
//  `credit_card_num` int(10) NOT NULL COMMENT '信用卡数量',
//  `credit_card_limit` decimal(15,2) NOT NULL COMMENT '新用卡总额度',
//  `data` json NOT NULL COMMENT '返回数据',
//  `fee` varchar(255) NOT NULL DEFAULT '' COMMENT '是否收费',
//  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
//  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
//  PRIMARY KEY (`id`) USING BTREE,
//  UNIQUE KEY `FK_USER_MULTIINFO_USER_ID` (`user_id`) USING BTREE,
//  CONSTRAINT `sgd_user_estimate_rep_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `sgd_user_auth` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
//) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='用户电商额度数据表'
        $userEvaluation['fund_money'] = !empty($params['credit_evaluation']['data']['fund_infos']['fund_basic']['balance']) ? $params['credit_evaluation']['data']['fund_infos']['fund_basic']['balance'] : 0;
//        if (isset($params['credit_evaluation']['data']['bank_infos'])) {
        $userEvaluation['year_income'] = !empty($params['credit_evaluation']['data']['bank_infos']['debit_card_info']['total_income']) ? $params['credit_evaluation']['data']['bank_infos']['debit_card_info']['total_income'] : 0;
        $userEvaluation['year_salary'] = !empty($params['credit_evaluation']['data']['bank_infos']['debit_card_info']['total_salary_income']) ? $params['credit_evaluation']['data']['bank_infos']['debit_card_info']['total_salary_income'] : 0;
        $userEvaluation['credit_card_num'] = !empty($params['credit_evaluation']['data']['bank_infos']['credit_card_info']['card_amount']) ? $params['credit_evaluation']['data']['bank_infos']['credit_card_info']['card_amount'] : 0;
        $userEvaluation['credit_card_limit'] = !empty($params['credit_evaluation']['data']['bank_infos']['credit_card_info']['total_credit_limit']) ? $params['credit_evaluation']['data']['bank_infos']['credit_card_info']['total_credit_limit'] : 0;
//        }
        $userEvaluation['data'] = json_encode($params['credit_evaluation']['data']);
        $userEvaluation['fee'] = $params['credit_evaluation']['fee'];
        $userEvaluation['create_at'] = date('Y-m-d H:i:s', time());
        $userEvaluation['update_at'] = date('Y-m-d H:i:s', time());
        return $userEvaluation;
    }

    /**
     * 获取额度评估(电商)
     * @param $params
     * @return mixed
     */
    public static function getAmountEst($params)
    {
        $userAmountEst['user_id'] = $params['user_id'];
        $userAmountEst['zm_score'] = $params['credit_qualification']['data']['qualification_info']['zm_score_info']['zm_score'];
        $userAmountEst['huabai_limit'] = $params['credit_qualification']['data']['qualification_info']['huabei_info']['huabai_limit'];
        $userAmountEst['credit_amt'] = $params['credit_qualification']['data']['qualification_info']['jiebei_info']['credit_amt'];
        $userAmountEst['data'] = json_encode($params['credit_qualification']['data']);
        $userAmountEst['fee'] = $params['credit_qualification']['fee'];
        $userAmountEst['create_at'] = date('Y-m-d H:i:s', time());
        $userAmountEst['update_at'] = date('Y-m-d H:i:s', time());
        return $userAmountEst;
    }

    /**
     * 获取贷后行为
     * @param $params
     * @return mixed
     */
    public static function getPostLoan($params)
    {
        $userPostLoan['user_id'] = $params['user_id'];
        $userPostLoan['transid'] = $params['post_load']['data']['trans_id'];
        $userPostLoan['due_days_non_cdq_12_mon'] = $params['post_load']['data']['loan_behavior_analysis']['feature_360d']['last_to_end_sure_due_non_cdq_all_time_m12'];
        $userPostLoan['pay_cnt_12_mon'] = $params['post_load']['data']['loan_behavior_analysis']['feature_360d']['sum_pay_cnt_all_pro_all_time_m12'];
        $userPostLoan['data'] = json_encode($params['post_load']['data']);
        $userPostLoan['fee'] = $params['post_load']['fee'];
        $userPostLoan['create_at'] = date('Y-m-d H:i:s', time());
        $userPostLoan['update_at'] = date('Y-m-d H:i:s', time());
        return $userPostLoan;
    }

    /**
     * 获取黑灰名单
     * @param $params
     * @return mixed
     */
    public static function getBlackList($params)
    {
        $userBlackList['user_id'] = $params['user_id'];
        $userBlackList['transid'] = $params['black_gray']['data']['trans_id'];
        $userBlackList['mobile_name_in_blacklist'] = (int)$params['black_gray']['data']['black_info_detail']['mobile_name_in_blacklist'];
        $userBlackList['idcard_name_in_blacklist'] = (int)$params['black_gray']['data']['black_info_detail']['idcard_name_in_blacklist'];
        $userBlackList['black_info_detail'] = json_encode($params['black_gray']['data']['black_info_detail']);
        $userBlackList['gray_info_detail'] = json_encode($params['black_gray']['data']['gray_info_detail']);
        $userBlackList['data'] = json_encode($params['black_gray']['data']);
        $userBlackList['fee'] = $params['black_gray']['fee'];
        $userBlackList['create_at'] = date('Y-m-d H:i:s', time());
        $userBlackList['update_at'] = date('Y-m-d H:i:s', time());
        return $userBlackList;
    }

    /**
     * 获取多头报告
     * @param $params
     * @return mixed
     */
    public static function getMultiInfo($params)
    {
        $userMultiinfo['user_id'] = $params['user_id'];
        $userMultiinfo['register_org_count'] = $params['multi_info']['data']['auth_queried_detail']['register_info']['org_count'];
        $userMultiinfo['loan_cnt'] = $params['multi_info']['data']['auth_queried_detail']['loan_info']['loan_cnt'];
        $userMultiinfo['loan_org_cnt'] = $params['multi_info']['data']['auth_queried_detail']['loan_info']['loan_org_cnt'];
        $userMultiinfo['transid'] = $params['multi_info']['data']['trans_id'];
        $userMultiinfo['data'] = json_encode($params['multi_info']['data']);
        $userMultiinfo['fee'] = $params['multi_info']['fee'];
        $userMultiinfo['create_at'] = date('Y-m-d H:i:s', time());
        $userMultiinfo['update_at'] = date('Y-m-d H:i:s', time());
        return $userMultiinfo;
    }


    /**
     * 获取个人信息
     * @param $params
     * @return mixed
     */
    public static function getPersonal($params)
    {
        $userPersonal['user_id'] = $params['user_id'];
        $userPersonal['idcard'] = $params['credit_qualification']['data']['person_info']['idcard'];
        $userPersonal['idcard_location'] = $params['credit_qualification']['data']['person_info']['idcard_location'];
        $userPersonal['mobile'] = $params['credit_qualification']['data']['person_info']['mobile'];
        $userPersonal['carrier'] = $params['credit_qualification']['data']['person_info']['carrier'];
        $userPersonal['mobile_location'] = $params['credit_qualification']['data']['person_info']['mobile_location'];
        $userPersonal['name'] = $params['credit_qualification']['data']['person_info']['name'];
        $userPersonal['age'] = $params['credit_qualification']['data']['person_info']['age'];
        $userPersonal['gender'] = $params['credit_qualification']['data']['person_info']['gender'];
        $userPersonal['email'] = $params['credit_qualification']['data']['person_info']['email'];
        $userPersonal['education'] = $params['credit_qualification']['data']['person_info']['education_info']['level'];
        $userPersonal['is_graduation'] = (int)$params['credit_qualification']['data']['person_info']['education_info']['is_graduation'];
        $userPersonal['create_at'] = date('Y-m-d H:i:s', time());
        $userPersonal['create_ip'] = Utils::ipAddress();
        $userPersonal['update_at'] = date('Y-m-d H:i:s', time());
        $userPersonal['update_ip'] = Utils::ipAddress();
        return $userPersonal;
    }
}
