<?php

namespace App\Models\Chain\Report\Scopion;

use App\Constants\OrderConstant;
use App\Helpers\Logger\SLogger;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;
use App\Services\Core\Validator\Scorpion\Mozhang\MozhangService;

class CreateAntifraudAction extends AbstractHandler
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
        if ($this->createAntifraud($this->params)) {
            $this->setSuccessor(new CreateApplyAction($this->params));
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


    private function createAntifraud($params)
    {
        SLogger::getStream()->error(__CLASS__);

//        `id` int(11) NOT NULL COMMENT 'id',
//  `user_id` int(11) NOT NULL COMMENT '用户id',
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

        $antifraud['user_id'] = $params['user_id'];//6
        $antifraud['user_report_id'] = $params['user_report_id'];//1
        $antifraud['courtcase_cnt'] = $params['anti_fraud']['data']['untrusted_info']['courtcase_cnt'];//0
        $antifraud['dishonest_cnt'] = $params['anti_fraud']['data']['untrusted_info']['dishonest_cnt'];//0
        $antifraud['fraudulence_is_hit'] = (int)($params['anti_fraud']['data']['fraudulence_info']['is_hit']);//0
        $antifraud['untrusted_info'] = json_encode($params['anti_fraud']['data']['untrusted_info']);//'{"people":[{"firstName":"Brett","lastName":"McLaughlin","email":"aaaa"},{"firstName":"Jason","lastName":"Hunter","email":"bbbb"},{"firstName":"Elliotte","lastName":"Harold","email":"cccc"}]}'
        $antifraud['suspicious_idcard'] = json_encode($params['anti_fraud']['data']['suspicious_idcard']);//'{"people":[{"firstName":"Brett","lastName":"McLaughlin","email":"aaaa"},{"firstName":"Jason","lastName":"Hunter","email":"bbbb"},{"firstName":"Elliotte","lastName":"Harold","email":"cccc"}]}'
        $antifraud['suspicious_mobile'] = json_encode($params['anti_fraud']['data']['suspicious_mobile']);//'{"people":[{"firstName":"Brett","lastName":"McLaughlin","email":"aaaa"},{"firstName":"Jason","lastName":"Hunter","email":"bbbb"},{"firstName":"Elliotte","lastName":"Harold","email":"cccc"}]}'
        $antifraud['data'] = json_encode($params['anti_fraud']['data']);//'{"people":[{"firstName":"Brett","lastName":"McLaughlin","email":"aaaa"},{"firstName":"Jason","lastName":"Hunter","email":"bbbb"},{"firstName":"Elliotte","lastName":"Harold","email":"cccc"}]}'
        $antifraud['fee'] = $params['anti_fraud']['fee'];//'Y'
        $antifraud['create_at'] = date('Y-m-d H:i:s', time());
        $antifraud['update_at'] = date('Y-m-d H:i:s', time());

        $antifraud = UserOrderFactory::createAntifraud($antifraud);
//        $this->params['user_report_id'] = $params['user_report_id'];


//        $userId = $params['user_id'];
//        $orderType = $params['order_type'];
//        $userOrder = UserOrderFactory::getUserOrderByUserIdAndOrderType($userId, $orderType);
//
        if (!$antifraud) {
            $this->error['error'] = "您好，报告记录关系异常！";
            return false;
        }
        return true;
    }
}
