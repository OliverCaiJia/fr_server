<?php

namespace App\Models\Factory\Api;

use App\Models\Orm\Bank;
use App\Models\Orm\UserBankcard;

/**
 * Class BanksFactory
 * @package App\Models\Factory
 * 银行卡工厂
 */
class UserBankcardFactory extends ApiFactory
{
    /**
     * @return bool
     * 添加银行卡
     */
    public static function createUserBank($data)
    {
        $userBanlk = new UserBankcard();
        $userBanlk->bank_card_no = $data['bank_card_no'];
        $userBanlk->bank_card_mobile = $data['bank_card_mobile'];
        $userBanlk->bank_code = $data['bank_code'];
        $userBanlk->idcard = $data['idcard'];
        $userBanlk->user_id = $data['user_id'];
        $userBanlk->bank_card_mobile = $data['bank_card_mobile'];
        $userBanlk->verify_time = $data['verify_time'];
        $userBanlk->create_at = $data['create_at'];
        $userBanlk->create_ip = $data['create_ip'];
        $userBanlk->update_at = $data['update_at'];
        $userBanlk->update_ip = $data['update_ip'];

        if($userBanlk->save()){
            return $userBanlk->toArray();
        }
        return false;
    }

    /**
     * @param $user_id
     * @return array
     * 银行卡列表
     */
    public static function getUserBankList($user_id)
    {
        $bankList = UserBankcard::where(['user_id' =>$user_id])
            ->get();

        return $bankList ? $bankList->toArray() : [];
    }

    /**
     * 获取银行信息，用户信息
     * @param array $params
     * @return array
     */
    public static function fetchUserbanksinfo($params = [])
    {
        $data = [];
        foreach ($params as $key => $val) {
            $bankinfo = BankFactory::fetchBankinfoById($val['bank_code']);
            $data[$key]['user_bank_id'] = $val['id'];
            $data[$key]['bank_name'] = $bankinfo['bank_name'];
            $data[$key]['bank_short_name'] = $bankinfo['bank_short_name'];
            $data[$key]['banklogo'] = $bankinfo['bank_logo'];
            $data[$key]['bank_color'] = $bankinfo['bank_color'];
            $data[$key]['is_default'] = $val['is_default'];
        }

        return $data ? $data : [];
    }

    /**
     * @param $bank_card_no 银行卡号
     * @return array
     * 获取指定银行卡
     */
    public static function getUserBank($bank_card_no)
    {
        $bankFirst = Bank::select()
            ->where(['bank_card_no' => $bank_card_no])
            ->first();

        return $bankFirst ? $bankFirst->toArray() : [];
    }

    /**
     * @param $id 主键id
     * @param $is_default 是否默认 0不是，1是
     * @return int
     * 更改默认值
     */
    public static function updateUserBank($id,$is_default)
    {
        $bankUpdate = UserBankcard::where(['id' => $id])
            ->update(['is_default' => $is_default]);

        return $bankUpdate;
    }

    /**
     * 判断是否已添加过该银行卡
     * @param array $params
     * @return array
     */
    public static function fetchUserBankByAccount($params = [])
    {
        $userbank = UserBankcard::where([
                'user_id' => $params['user_id'],
                'bank_card_no' => $params['bankcard'],
            ])->first();

        return $userbank ? $userbank->toArray() : [];
    }

    /**
     * 获取默认银行卡信息
     * @card_type 银行卡类型 【0:储蓄卡,1:信用卡】
     * @card_default 默认状态【0未默认，1已默认】
     * @param $userid
     * @return mixed|string
     */
    public static function getDefaultBankCardIdById($userId)
    {
        $res = UserBankcard::select('id')
            ->where(['user_id' => $userId, 'status' => 1, 'bank_card_type' => 0,  'is_default' => 1])->pluck('id');
        return $res ? $res->toArray() : [];
    }

    /**
     * 取消默认卡储蓄卡
     * @card_type 银行卡类型 【1:储蓄卡,2:信用卡】
     * @card_default 默认状态【0未默认，1已默认】
     * @card_use  使用状态【0信用资料，1认证银行】
     * @param array $data
     * @return bool
     */
    public static function deleteDefaultById($data = [])
    {
        return UserBankcard::where([
            'user_id' => $data['userId'],
            'status' => 1,
        ])->whereIn('id', $data['ids'])
            ->update(['is_default' => 0]);
    }

    /**
     * 设置默认卡储蓄卡
     * @param array $params
     * @return bool
     */
    public static function setDefaultById($params = [])
    {
        return UserBankcard::where([
            'id' => $params['userbankId'],
            'status' => 1,
            'user_id' => $params['userId'],
        ])
            ->update(['is_default' => 1]);
    }
}