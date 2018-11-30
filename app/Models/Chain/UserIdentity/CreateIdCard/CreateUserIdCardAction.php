<?php

namespace App\Models\Chain\UserIdentity\CreateIdCard;

use App\Helpers\Utils;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserRealnameFactory;

/**
 * 添加sd_user_rename用户身份证信息
 * Class SendImageToQiniuAction
 * @package App\Models\Chain\UserIdentity\IdcardFront
 *
 */
class CreateUserIdCardAction extends AbstractHandler
{
    private $params = array();
    protected $data = array();
    protected $error = array('error' => '用户身份证添加有误！', 'code' => 10007);

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * 添加sd_user_rename用户身份证信息
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
     * 添加sd_user_rename用户身份证信息
     * @param $params
     * @return bool
     *
     */
    private function updateUserBanks($params)
    {
        $birthday = strlen($params['id_card_no'])==15 ? ('19' . substr($params['id_card_no'], 6, 6)) : substr($params['id_card_no'], 6, 8);
        $data['user_id'] = $params['user_id'];
        $data['real_name'] = $params['real_name'];
        $data['gender'] = $params['gender'];
        $data['id_card_type'] = 0;
        $data['id_card_no'] = $params['id_card_no'];
        $data['birthday'] = date('Y-m-d',strtotime($birthday));
        $data['id_card_front_img'] = $params['id_card_front_img'];
        $data['id_card_back_img'] = $params['id_card_back_img'];
        $data['issued_by'] = $params['issued_by'];
        $data['valid_start_date'] = $params['valid_start_date'];
        $data['valid_end_date'] = $params['valid_end_date'];
        $data['create_at'] = date('Y-m-d H:i:s', time());
        $data['create_ip'] = Utils::ipAddress();
        $data['update_at'] = date('Y-m-d H:i:s', time());
        $data['update_ip'] = Utils::ipAddress();

        $this->data = $res = UserRealnameFactory::createUserCard($data);

        return $res;
    }

}
