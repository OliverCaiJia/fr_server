<?php

namespace App\Models\Factory\Api;

use App\Models\Factory\Api\ApiFactory;
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
        $addBank = UserBankcard::save($data);

        return $addBank;
    }

    /**
     * @param $user_id
     * @return array
     * 银行卡列表
     */
    public static function getUserBankList($user_id)
    {
        $bankList = UserBankcard::select(['id', 'user_id', 'bank_card_no', 'bank_card_type','is_default','bank_card_mobile'])
            ->where(['user_id' =>$user_id])
            ->get();

        return $bankList ? $bankList->toArray() : [];
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
}