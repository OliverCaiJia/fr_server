<?php

namespace App\Models\Chain\UserBank\Add;

use App\Helpers\Utils;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserBankcardFactory;
use App\Models\Factory\Api\UserRealnameFactory;

/**
 * 添加sd_user_banks用户银行卡信息
 * Class SendImageToQiniuAction
 * @package App\Models\Chain\UserIdentity\IdcardFront
 *
 */
class CreateUserBanksAction extends AbstractHandler
{
    private $params = array();
    protected $data = array();
    protected $error = array('error' => '用户银行卡添加有误！', 'code' => 10007);

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * 添加sd_user_banks用户银行卡信息
     * @return array|bool
     *
     */
    public function handleRequest()
    {
        if ($this->updateUserBanks($this->params) == true) {
            return $this->data;
        } else {
            return $this->error;
        }
    }

    /**
     * 添加sd_user_banks用户银行卡信息
     * @param $params
     * @return bool
     *
     */
    private function updateUserBanks($params)
    {
        $data['bank_card_no'] = $params['bankcard'];
        $data['bank_card_mobile'] = $params['mobile'];
        $data['bank_code'] = $params['bank_code'];
        $data['idcard'] = $params['idcard'];
        $data['user_id'] = $params['user_id'];
        $data['bank_card_mobile'] = $params['mobile'];
        $data['verify_time'] = date('Y-m-d H:i:s', time());
        $data['create_at'] = date('Y-m-d H:i:s', time());
        $data['create_ip'] = Utils::ipAddress();
        $data['update_at'] = date('Y-m-d H:i:s', time());
        $data['update_ip'] = Utils::ipAddress();

        $this->data = $res = UserBankCardFactory::createUserBank($data);

        return $res;
    }

}
