<?php

namespace App\Models\Chain\Order\NoPayOrder\LoanOrder;

use App\Helpers\Logger\SLogger;
use App\Models\Chain\AbstractHandler;
use App\Models\Chain\Order\Loan\CreateApplyUserOrderAction;
use App\Models\Factory\Api\UserAuthFactory;
use App\Models\Factory\Api\UserBasicFactory;
use App\Models\Factory\Api\UserCertifyFactory;
use App\Models\Factory\Api\UserLoanTaskFactory;
use App\Models\Factory\Api\UserOrderFactory;
use App\Models\Factory\Api\UserRealnameFactory;
use App\Models\Orm\UserCertify;
use App\Services\Core\Push\Yijiandai\YiJianDaiPushService;

class CreatePushTaskAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '订单数量必须是1！', 'code' => 8210];

    public function __construct($params)
    {
        $this->params = $params;
    }


//    public function handleRequest()
//    {
//        if ($this->createLoanTask($this->params)) {
//            return true;
//        } else {
//            return $this->error;
//        }
//    }

    public function handleRequest()
    {
        $data = self::getLoanParams($this->params);
////        dd($data);
//        array:9 [
//        "user_id" => 6
//  "type_id" => 0
//  "spread_nid" => "oneLoan"
//  "request_data" => "{"mobile":"13810560398","name":"\u5de8\u7428","certificate_no":"610303197911112419","sex":0,"birthday":true,"has_insurance":1,"house_info":"001","car_info":"001","occupation":"001","salary_extend":"000","salary":"001","accumulation_fund":"001","work_hours":"003","business_license":"002","has_creditcard":1,"social_security":1,"is_micro":1,"city":"","money":"666"}"
//  "response_data" => "{}"
//  "status" => 0
//  "create_at" => "2018-11-29 18:19:06"
//  "send_at" => "2018-11-29 18:19:06"
//  "update_at" => "2018-11-29 18:19:06"
//]
        $result = UserLoanTaskFactory::createLoanTask($data);
        if ($result) {
            return $result;
        }
        return $this->error;
    }

    private function getLoanParams($params)
    {
//mobile, name, certificate_no, sex, birthday, has_insurance, house_info, car_info,
// occupation, salary_extend, salary, accumulation_fund, work_hours, business_license,
// has_creditcard, social_security, is_micro, city,

        $userBasic = UserBasicFactory::getUserBasicByUserId($params['user_id']);
//        dd($userBasic);
//        array:22 [
//        "id" => 5
//  "user_id" => 6
//  "user_location" => "北京"
//  "user_address" => "中国"
//  "profession" => 1
//  "company_name" => "公司"
//  "company_location" => "北京"
//  "company_address" => "海淀"
//  "company_license_time" => 0
//  "work_time" => 3
//  "month_salary" => 1
//  "zhima_score" => 123
//  "house_fund_time" => 10
//  "has_social_security" => 1
//  "has_house" => 1
//  "has_auto" => 1
//  "has_house_fund" => 1
//  "has_creditcard" => 1
//  "has_assurance" => 1
//  "has_weilidai" => 1
//  "create_at" => "2018-11-29 13:46:05"
//  "update_at" => "2018-11-29 13:46:05"
//]
        $userAuth = UserAuthFactory::getUserById($params['user_id']);
//        dd($userAuth);
//        array:12 [
//        "id" => 6
//  "user_name" => "13810560398"
//  "mobile" => "13810560398"
//  "password" => ""
//  "status" => 1
//  "auth_key" => "1"
//  "access_token" => "lWWDKwbhNI5NY3USvQICtgBHUVpieEPr"
//  "expire_at" => "2018-11-19 17:54:08"
//  "create_at" => "2018-11-29 15:06:13"
//  "create_ip" => "127.0.0.1"
//  "last_login_at" => "2018-11-29 13:54:43"
//  "last_login_ip" => "117.136.0.177"
//]
        $userRealName = UserRealnameFactory::getUserRealnameByUserId($params['user_id']);
//dd($userRealName);
//        array:16 [
//        "id" => 2
//  "user_id" => 6
//  "real_name" => "巨琨"
//  "gender" => 0
//  "id_card_type" => 0
//  "id_card_no" => "610303197911112419"
//  "birthday" => ""
//  "id_card_front_img" => "1"
//  "id_card_back_img" => "1"
//  "issued_by" => "1"
//  "valid_start_date" => "2018-11-16"
//  "valid_end_date" => "2018-11-16"
//  "create_at" => "2018-11-16 22:19:39"
//  "create_ip" => "1"
//  "update_at" => "2018-11-16 22:19:39"
//  "update_ip" => "1"
//]

        $licenseDay = $userBasic['company_license_time'];
        $now = date('Y-m-d H:i:s');

        $days = self::diffBetweenTwoDays($licenseDay, $now);
        $orderType = UserOrderFactory::getOrderTypeByTypeNid('order_apply');
        $userOrder = UserOrderFactory::getUserOrderByUserIdAndOrderType($params['user_id'], $orderType['id']);

        $requestData = array(
            'mobile' => $userAuth['mobile'],
            'name' => $userRealName['real_name'],
            'certificate_no' => $userRealName['id_card_no'],
            'sex' => $userRealName['gender'],
            'birthday' => isset($userRealName['birthday']) ?: '1990-01-01',
            'has_insurance' => $userBasic['has_assurance'],
            'house_info' => '00' . $userBasic['has_house'],
            'car_info' => '00' . $userBasic['has_auto'],
            'occupation' => '00' . $userBasic['profession'],
            'salary_extend' => '00' . $userBasic['salary_deliver'],
            'salary' => '00' . $userBasic['month_salary'],
            'accumulation_fund' => '00' . $userBasic['has_house_fund'],
            'work_hours' => '00' . $userBasic['work_time'],
            'business_license' => ($days < 365) ? '001' : '002',
            'has_creditcard' => $userBasic['has_creditcard'],
            'social_security' => $userBasic['has_social_security'],
            'is_micro' => $userBasic['has_weilidai'],
            'city' => $userBasic['city'],
            'money' => empty($userOrder['money']) ? 10000 : $userOrder['money']
        );
        SLogger::getStream()->error(__CLASS__.'===='.json_encode($requestData));
//        dd($data);
//        array:19 [
//        "mobile" => "13810560398"
//  "name" => "巨琨"
//  "certificate_no" => "610303197911112419"
//  "sex" => 0
//  "birthday" => true
//  "has_insurance" => 1
//  "house_info" => "001"
//  "car_info" => "001"
//  "occupation" => "001"
//  "salary_extend" => "000"
//  "salary" => "001"
//  "accumulation_fund" => "001"
//  "work_hours" => "003"
//  "business_license" => "002"
//  "has_creditcard" => 1
//  "social_security" => 1
//  "is_micro" => 1
//  "city" => ""
//  "money" => "666"
//]
        //todo::入loan_task表
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

//        dd($params);
//        array:3 [
//        "order_no" => "SGD-A-20181123162814-401156"
//  "money" => "666"
//  "user_id" => 6
//]
        $data['user_id'] = $params['user_id'];
        $data['type_id'] = 0;
        $data['spread_nid'] = 'oneLoan';
        $data['request_data'] = json_encode($requestData);
        $data['response_data'] = json_encode(new \ArrayObject());
        $data['status'] = 0;
        $data['create_at'] = date('Y-m-d H:i:s', time());
        $data['send_at'] = date('Y-m-d H:i:s', time());
        $data['update_at'] = date('Y-m-d H:i:s', time());
        return $data;
    }

    private function diffBetweenTwoDays($day1, $day2)
    {
        $second1 = strtotime($day1);
        $second2 = strtotime($day2);

        if ($second1 < $second2) {
            $tmp = $second2;
            $second2 = $second1;
            $second1 = $tmp;
        }
        return ($second1 - $second2) / 86400;
    }
}
