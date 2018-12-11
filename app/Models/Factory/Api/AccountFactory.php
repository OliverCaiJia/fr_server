<?php

namespace App\Models\Factory\Api;

use App\Constants\AccountConstant;
use App\Helpers\Utils;
use App\Models\Factory\Api\ApiFactory;
use App\Models\Orm\UserAccount;
use App\Models\Orm\UserAccountLog;

class AccountFactory extends ApiFactory
{

    /** 我的账号余额
     * @param array $data
     * @return mixed
     */
    public static function fetchBalance($userId)
    {
        $account = UserAccount::select(['balance'])->where(['user_id' => $userId])->first();
        return $account ? $account->balance : AccountConstant::ACCOUNT_NULL;
    }

    /**
     * 用户账户信息   Array
     * @param $userId
     * @return array
     */
    public static function fetchUserAccount($userId)
    {
        $userAccountArr = UserAccount::where(['user_id' => $userId])->first();
        return $userAccountArr ? $userAccountArr->toArray() : [];
    }

    /**
     * @param $userId
     * @return UserAccount
     * 用户账户信息   Object
     */
    public static function fetchUserAccounts($userId)
    {
        $userAccountObj = UserAccount::where(['user_id' => $userId])->first();
        return $userAccountObj ?: (new UserAccount());
    }

    /**
     * 用户账户流水
     * @param $userId
     * @return mixed
     */
    public static function fetchUserAccountLog($userId)
    {
        $accountLogArr = UserAccountLog::select(['income', 'expend', 'remark', 'create_at'])
            ->where(['user_id' => $userId])
            ->orderBy('create_at', 'desc')
            ->get()->toArray();
        return $accountLogArr;
    }

    /**
     * @param $params
     * @return bool
     * 添加账户流水
     */
    public static function createAccountLog($params)
    {
        $accountLog = new UserAccountLog();
        $res = $accountLog->insert($params);

        return $res ? $res : false;
    }

    /**
     * @param $params
     * 修改用户账户信息（加现金）
     * 1、账号增加钱（money）
     * （1）balance_frost += money;
     * （2）balance_frost -= money;
     * balance_cash += money;
     * balance = balance_cash + balance_frost;
     * （3）income +=money;
     * total = income - expend;
     * total，balance，frost 不直接操作，通过公式计算得出
     */
    /**
     * @param $params
     * @return mixed
     */
    public static function addAccount($params)
    {
        $userId = $params['userId'];
        $income = $params['income_money'];
        $income_money = intval($income);
        //锁行
        $userAccountObj = UserAccount::lockForUpdate()->firstOrCreate(['user_id' => $userId], [
            'user_id' => $userId,
            'balance_cash' => $income_money,
            'balance' => $income_money,
            'income' => $income_money,
            'total' => $income_money,
            'updated_at' => date('Y-m-d H:i:s', time()),
            'updated_ip' => Utils::ipAddress(),
        ]);
        //修改
        $userAccountObj->user_id = $userId;
        $userAccountObj->balance_frost += $income_money;
        $userAccountObj->balance_frost -= $income_money;
        $userAccountObj->balance_cash += $income_money;
        $userAccountObj->balance = $userAccountObj->balance_frost + $userAccountObj->balance_cash;
        $userAccountObj->income += $income_money;
        $userAccountObj->total = $userAccountObj->income - $userAccountObj->expend;
        $userAccountObj->updated_at = date('Y-m-d H:i:s', time());
        $userAccountObj->updated_ip = Utils::ipAddress();
        return $userAccountObj->save();
    }

    /**
     * @param $params
     * 修改用户账户信息（减现金）
     * 1、账号减少钱（money）
     */
    /**
     * @param $params
     * @return mixed
     */
    public static function reduceAccount($params)
    {

    }

    /**
     * @return array
     * 查询账户income 小于0的数据
     */
    public static function fetchAccounts()
    {
        $account = UserAccount::select()
            ->where('income', '<', 0)
            ->orWhere('total', '<', 0)
            ->limit(100)
            ->get()->toArray();

        return $account ? $account : [];
    }

    /**
     * 创建用户账户
     * @param $params
     * @return bool
     */
    public static function createUserAccount($params)
    {
        $userAccount = UserAccount::where('user_id',$params['user_id'])->first();
        if(empty($userAccount)){
            $userAccount = new UserAccount();
        }
        $userAccount->user_id = $params['user_id'];
        $userAccount->expend += $params['amount']/100;
        $userAccount->status = $params['status'];
        $userAccount->create_at = date('Y-m-d H:i:s');
        $userAccount->create_ip = Utils::ipAddress();
        if($userAccount->save()){
            return true;
        }
        return false;
    }
}
