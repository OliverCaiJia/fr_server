<?php

namespace App\Models\Chain\Order\NoPayOrder\LoanOrder;

use App\Helpers\Logger\SLogger;
use App\Helpers\Utils;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserAuthFactory;
use App\Models\Factory\Api\UserBasicFactory;
use App\Models\Factory\Api\UserLoanTaskFactory;
use App\Models\Factory\Api\UserOrderFactory;
use App\Models\Factory\Api\UserRealnameFactory;

class CreatePushTaskAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '订单数量必须是1！', 'code' => 8210];

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function handleRequest()
    {
        $task = $this->createLoanTask();
        if ($task) {
            return $task;
        }
        return $this->error;
    }

    private function createLoanTask()
    {

        $data = $this->getLoanParams($this->params);
        return UserLoanTaskFactory::createLoanTask($data);
    }

    private function getLoanParams($params)
    {
        SLogger::getStream()->error(__CLASS__);
        $userBasic = UserBasicFactory::getUserBasicByUserId($params['user_id']);
        $userLocationArr = explode(',', $userBasic['user_location']);
        if (isset($userLocationArr) && count($userLocationArr) >= 2) {
            $city = $userLocationArr[1];
        }

        $userAuth = UserAuthFactory::getUserById($params['user_id']);

        $userRealName = UserRealnameFactory::getUserRealnameByUserId($params['user_id']);

        $birthday = Utils::getBirthdayByIdCard($userRealName['id_card_no']);
        $licenseDay = $userBasic['company_license_time'];
        $now = date('Y-m-d H:i:s');

        $days = $this->diffBetweenTwoDays($licenseDay, $now);
        $orderType = UserOrderFactory::getOrderTypeByTypeNid('order_apply');
        $userOrder = UserOrderFactory::getUserOrderByUserIdAndOrderType($params['user_id'], $orderType['id']);

        $requestData = array(
            'mobile' => $userAuth['mobile'],
            'name' => $userRealName['real_name'],
            'certificate_no' => $userRealName['id_card_no'],
            'sex' => $userRealName['gender'],
            'birthday' => $birthday ?: '1990-01-01',
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
            'city' => $city,
            'money' => empty($userOrder['money']) ? 10000 : $userOrder['money']
        );
        SLogger::getStream()->error(__CLASS__ . '====' . json_encode($requestData));

        $data['user_id'] = $params['user_id'];
        $data['type_id'] = 0;//平台推送
        $data['loan_order_no'] = $params['order_no'];
        $data['spread_nid'] = 'oneLoan';
        $data['request_data'] = json_encode($requestData);
        $data['response_data'] = json_encode(new \ArrayObject());
        $data['status'] = 0;//未激活
        $data['retrieve_req_data'] = json_encode(new \ArrayObject());
        $data['retrieve_rsp_data'] = json_encode(new \ArrayObject());
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
