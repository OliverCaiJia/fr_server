<?php

namespace App\Strategies;

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

    public static function getEvaluation($params)
    {
//        {
//            "success": boolean,
//  "code": "string",
//  "msg": "string",
//  "data": {
//            "person_info": {
//                "idcard": "string",
//          "idcard_location": "string",
//          "mobile": "string",
//          "carrier": "string",
//          "mobile_location": "string",
//          "name": "string",
//          "age": int,
//          "gender": "string",
//          "email": "string",
//           "education_info": {
//                    "level": int,
//            "is_graduation": boolean
//          }
//       },
//       "fund_infos": [
//        {
//            "fund_basic": {
//            "last_pay_date": "string",
//                "update_date": "string",
//                "open_date": "string",
//                "open_location": "string",
//                "account_status": "string",
//                "balance": "string",
//                "base_amount": "string",
//                "monthly_income": "string"
//            },
//            "fund_statistics": {
//            "continuous_months": int,
//                "repay_times": int,
//                "total_companies": int,
//                "total_months": int
//            }
//        }
//       ],
//       "bank_infos": {
//                "debit_card_info": {
//                    "update_date": "string",
//                "card_amount": int,
//                "balance": "string",
//                "total_income": "string",
//                "total_salary_income": "string",
//                "total_loan_income": "string",
//                "total_outcome": "string",
//                "total_consume_outcome": "string",
//                "total_loan_outcome": "string"
//            },
//            "credit_card_info": {
//                    "update_date": "string",
//                "card_amount": int,
//                "total_credit_limit": "string",
//                "total_credit_available": "string",
//                "max_credit_limit": "string",
//                "overdue_times": int,
//                "overdue_months": int
//            }
//  }
//  }
//  "fee": "string"
//}

//        CREATE TABLE `sgd_user_estimate_rep` (
//    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
//  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
//  `user_report_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关联的user_reports表的id',---------------------
//  `fund_money` decimal(15,2) NOT NULL COMMENT '公积金余额',
//  `year_income` decimal(15,2) NOT NULL COMMENT '年收入',
//  `year_salary` decimal(15,2) NOT NULL COMMENT '年工资',
//  `credit_card_num` int(10) NOT NULL COMMENT '信用卡数量',
//  `credit_card_limit` decimal(15,2) NOT NULL COMMENT '新用卡总额度',
//  `data` json NOT NULL COMMENT '返回数据',
//  `fee` varchar(255) NOT NULL DEFAULT '' COMMENT '是否收费',
//  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
//  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
//  PRIMARY KEY (`id`),
//  UNIQUE KEY `FK_USER_MULTIINFO_USER_ID` (`user_id`) USING BTREE,
//  CONSTRAINT `sgd_user_estimate_rep_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `sgd_user_auth` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
//) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COMMENT='用户电商额度数据表'
        $userEvaluation['user_id'] = $params['user_id'];
        $userEvaluation['fund_money'] = $params['evaluation']['data']['trans_id'];
        $userEvaluation['data'] = json_encode($params['application']['data']);
        $userEvaluation['fee'] = $params['application']['fee'];
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
