<?php

namespace App\Models\Chain\Report\Scopion;

use App\Constants\OrderConstant;
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
     *s
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
//        dd($params);
//        $moZhang = new MozhangService();
        $pullResult = MozhangService::o()->getMoZhangContent($params['name'], $params['idCard'], $params['mobile'], $params['num']);
        dd($pullResult);

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
        $data['user_id'] = $params['user_id'];
        $data['user_report_id'] = $params['user_report_id'];
        $data['courtcase_cnt'] = $params['courtcase_cnt'];
        $data['dishonest_cnt'] = $params['dishonest_cnt'];
        $data['fraudulence_is_hit'] = $params['fraudulence_is_hit'];
        $data['untrusted_info'] = $params['untrusted_info'];
        $data['suspicious_idcard'] = $params['suspicious_idcard'];
        $data['suspicious_mobile'] = $params['suspicious_mobile'];
        $data['data'] = $params['data'];
        $data['fee'] = $params['fee'];
        $data['create_at'] = $params['create_at'];
        $data['update_at'] = $params['update_at'];

        $userReportLog = UserOrderFactory::createAntifraud($data);

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
