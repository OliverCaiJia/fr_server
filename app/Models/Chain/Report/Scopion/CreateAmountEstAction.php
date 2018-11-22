<?php

namespace App\Models\Chain\Report\Scopion;

use App\Constants\OrderConstant;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;

class CreateAmountEstAction extends AbstractHandler
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
        if ($this->createAmountEst($this->params)) {
            $this->setSuccessor(new CreatePostLoanAction($this->params));
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

    private function createAmountEst($params)
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

        //        array:5 [▼
//  "success" => true
//  "code" => "0000"
//  "msg" => "操作成功"
//  "data" => array:3 [▼
//    "trans_id" => "d07e1210-ecbc-11e8-bea7-00163e0d2aee"
//    "person_info" => array:10 [▼
//      "idcard" => "13070219811107****"
//      "idcard_location" => "河北省/张家口市/桥东区"
//      "mobile" => "1381056****"
//      "carrier" => "中国移动"
//      "mobile_location" => "北京/北京"
//      "name" => "蔡*"
//      "age" => 37
//      "gender" => "男"
//      "email" => ""
//      "education_info" => array:2 [▼
//        "level" => 0
//        "is_graduation" => false
//      ]
//    ]
//    "qualification_info" => array:3 [▼
//      "zm_score_info" => array:2 [▼
//        "last_modify_time" => ""
//        "zm_score" => ""
//      ]
//      "huabei_info" => array:2 [▼
//        "last_modify_time" => ""
//        "huabai_limit" => ""
//      ]
//      "jiebei_info" => array:2 [▼
//        "last_modify_time" => ""
//        "credit_amt" => ""
//      ]
//    ]
//  ]
//  "fee" => "N"
//]
//
        $data['user_id'] = $params['user_id'];//6
        $data['user_report_id'] = $params['user_report_id'];//1
        $data['zm_score'] = $params['credit_qualification']['data']['qualification_info']['zm_score_info']['zm_score'];//1
        $data['huabai_limit'] = $params['credit_qualification']['data']['qualification_info']['huabei_info']['huabai_limit'];//1
        $data['credit_amt'] = $params['credit_qualification']['data']['qualification_info']['jiebei_info']['credit_amt'];//1
        $data['data'] = json_encode($params['credit_qualification']['data']);//'{"people":[{"firstName":"Brett","lastName":"McLaughlin","email":"aaaa"},{"firstName":"Jason","lastName":"Hunter","email":"bbbb"},{"firstName":"Elliotte","lastName":"Harold","email":"cccc"}]}'
        $data['fee'] = $params['credit_qualification']['fee'];//'Y'
        $data['create_at'] = date('Y-m-d H:i:s', time());
        $data['update_at'] = date('Y-m-d H:i:s', time());




        $userAmountEst = UserOrderFactory::createAmountEst($data);


//        $data['idcard'] = $params['idcard'];//oooo
//        $data['idcard_location'] = $params['idcard_location'];//oooo
//        $data['mobile'] = $params['mobile'];//oooo
//        $data['carrier'] = $params['carrier'];//
//        $data['mobile_location'] = $params['mobile_location'];//
//        $data['name'] = $params['name'];//
//        $data['age'] = $params['age'];//
//        $data['gender'] = $params['gender'];//
//        $data['email'] = $params['email'];//
//        $data['education'] = $params['education'];//
//        $data['is_graduation'] = $params['is_graduation'];//oooo
//
//        dd($userAmountEst);



        $this->params['personal_idcard'] = $params['credit_qualification']['data']['person_info']['idcard'];
        $this->params['personal_idcard_location'] = $params['credit_qualification']['data']['person_info']['idcard_location'];
        $this->params['personal_mobile'] = $params['credit_qualification']['data']['person_info']['mobile'];
        $this->params['personal_carrier'] = $params['credit_qualification']['data']['person_info']['carrier'];
        $this->params['personal_mobile_location'] = $params['credit_qualification']['data']['person_info']['mobile_location'];
        $this->params['personal_name'] = $params['credit_qualification']['data']['person_info']['name'];
        $this->params['personal_age'] = $params['credit_qualification']['data']['person_info']['age'];
        $this->params['personal_gender'] = $params['credit_qualification']['data']['person_info']['gender'];
        $this->params['personal_email'] = $params['credit_qualification']['data']['person_info']['email'];
        $this->params['personal_education'] = $params['credit_qualification']['data']['person_info']['education_info']['level'];
        $this->params['personal_is_graduation'] = (int)$params['credit_qualification']['data']['person_info']['education_info']['is_graduation'];






//        $userId = $params['user_id'];
//        $orderType = $params['order_type'];
//        $userOrder = UserOrderFactory::getUserOrderByUserIdAndOrderType($userId, $orderType);
//
        if (!$userAmountEst) {
            $this->error['error'] = "您好，报告记录关系异常！";
            return false;
        }
        return true;
    }
}
