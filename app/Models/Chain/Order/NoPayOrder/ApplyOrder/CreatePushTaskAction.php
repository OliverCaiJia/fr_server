<?php

namespace App\Models\Chain\Order\NoPayOrder\ApplyOrder;

use App\Models\Chain\AbstractHandler;
use App\Models\Chain\Order\Loan\CreateApplyUserOrderAction;
use App\Models\Factory\Api\UserAuthFactory;
use App\Models\Factory\Api\UserBasicFactory;
use App\Models\Factory\Api\UserCertifyFactory;
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


    public function handleRequest()
    {
        if ($this->checkCount($this->params)) {
            $this->setSuccessor(new CreateApplyUserOrderAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    private function checkCount($params)
    {
//mobile, name, certificate_no, sex, birthday, has_insurance, house_info, car_info,
// occupation, salary_extend, salary, accumulation_fund, work_hours, business_license,
// has_creditcard, social_security, is_micro, city,

        $userBasic = UserBasicFactory::fetchUserBasic($params['user_id']);

        $userAuth = UserAuthFactory::getUserById($params['user_id']);
        $userRealName = UserRealnameFactory::fetchUserRealname($params['user_id']);
        $userCertify = UserCertifyFactory::fetchUserCertify($params['user_id']);
        $licenseDay = $userBasic['company_license_time'];
        $now = date('Y-m-d H:i:s');

        $days = self::diffBetweenTwoDays($licenseDay, $now);


        $data = array(
            'mobile' => $userAuth['mobile'],
            'name' => $userRealName['real_name'],
            'certificate_no' => $userRealName['id_card_no'],
            'sex' => $userRealName['gender'],
            'birthday' => $userCertify['birthday'],
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
            'city' => $userBasic['city']
        );

        $key = '7BFCF5C921231SDZ';//密钥
        $channel = 'oneloan_165';//渠道名
        $iv = $password = substr(md5($key), 0, 16);//AES算法的密码password和初始变量iv

        $yiJianDai = YiJianDaiPushService::o()->sendPush($data);

        dd($yiJianDai);

        //加密
        $string = json_encode($data);
        $encrypted = openssl_encrypt($string, 'AES-128-CBC', $password, 1, $iv);
        $en_result = base64_encode($encrypted); //bizData 密文数据
//        echo "加密：";
//        var_dump($en_result);
        //签名
        $post = array('channel'=>$channel,'bizData'=>$en_result);
        $sign = self::getSignInfo($post,$key);
//        var_dump($sign);



        //todo::入task_loan表
        $count = 1;
        if ($count != 1) {//处理中
            $this->error['error'] = "您好，订单数量必须是一！";
            return false;
        }
        return true;
    }

    private function getSignInfo($params = array(),$key) {
        $srcStr = "";
        $names = array();
        foreach($params as $name => $value) {
            $names[$name] = $name;
        }

        sort($names);

        foreach($names as $name) {
            $srcStr = $srcStr.$name."=".$params[$name]."&";
        }

        $srcStr = substr($srcStr, 0, strlen($srcStr) - 1);

        return md5($srcStr.$key);

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
