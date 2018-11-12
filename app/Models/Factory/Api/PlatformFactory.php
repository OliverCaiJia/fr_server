<?php

namespace App\Models\Factory\Api;

use App\Models\Orm\AccountPayment;
use App\Models\Orm\Platform;

class PlatformFactory extends ApiFactory
{

    public static function createPlatform($params)
    {
        $platformObj = new Platform();
//        $userOrderObj->user_id = $params['user_id'];
//        $userOrderObj->bank_id = $params['bank_id'];
//        $userOrderObj->order_no = $params['order_no'];
//        $userOrderObj->payment_order_no = $params['payment_order_no'];
//        $userOrderObj->order_expired = $params['order_expired'];
//        $userOrderObj->order_type = $params['order_type'];
//        $userOrderObj->payment_type = $params['payment_type'];
//        $userOrderObj->pay_type = $params['pay_type'];
//        $userOrderObj->terminaltype = $params['terminaltype'];
//        $userOrderObj->terminalid = $params['terminalid'];
//        $userOrderObj->card_num = $params['card_num'];
//        $userOrderObj->lastno = $params['lastno'];
//        $userOrderObj->cardtype = $params['cardtype'];
//        $userOrderObj->amount = $params['amount'];
//        $userOrderObj->status = $params['status'];
//        $userOrderObj->request_text = $params['request_text'];
//        $userOrderObj->response_text = $params['response_text'];
//        $userOrderObj->user_agent = $params['user_agent'];
//        $userOrderObj->create_ip = Utils::ipAddress();
//        $userOrderObj->update_ip = Utils::ipAddress();
//        $userOrderObj->create_at = date('Y-m-d H:i:s', time());
        return $platformObj->save();
    }

    /**
     * 根据平台唯一标识获取平台信息
     * @param $platform_nid
     * @return mixed
     */
    public static function getPlatformByNid($platform_nid)
    {
        return Platform::select()->where('platform_nid', '=', $platform_nid)->get();
    }
}
