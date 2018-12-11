<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Logger\SLogger;
use App\Helpers\RestResponseFactory;
use App\Helpers\RestUtils;
use App\Http\Controllers\Api\ApiController;
use App\Models\Factory\Api\BankFactory;
use App\Models\Chain\UserBank\Add\DoAddHandler;
use App\Models\Factory\Api\UserBankcardFactory;
use App\Models\Factory\Api\UserRealnameFactory;
use Illuminate\Http\Request;
use App\Models\Chain\UserBank\Defaultcard\DoDefaultcardHandler;

/**
 * 银行卡设置
 */
class BanksController extends ApiController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 银行卡添加
     */
    public function createUserBank(Request $request)
    {
        //获取所有数据
        $data = $request->all();
        $data['user_id'] = $this->getUserId($request);
        //银行卡责任链
        $bankcard = new DoAddHandler($data);
        $result = $bankcard->handleRequest();
        //错误提示
        if (isset($result['error'])) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), $result['error'], $result['code'], $result['error']);
        }

        $res['id'] = $result['id'];
        return RestResponseFactory::ok($res);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 银行卡校验
     */
    public static function verify(Request $request)
    {
        return RestResponseFactory::ok();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 银行卡删除
     */
    public function delete(Request $request)
    {
        return RestResponseFactory::ok();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 银行卡列表
     */
    public function fetchUserBanks(Request $request)
    {
        $userId = $this->getUserId($request);


        SLogger::getStream()->error(__CLASS__);
        SLogger::getStream()->error(json_encode($userId));
        SLogger::getStream()->error(__CLASS__);
        //用户绑定银行卡列表
        $userbanks['list'] = UserBankcardFactory::getUserBankList($userId);

        //暂无数据
        $cards = [];
        if (!empty($userbanks['list'])) {
            //获取银行信息，用户信息
            $cards = UserBankcardFactory::fetchUserbanksinfo($userbanks['list']);
        }
        $banks['list'] = $cards;

        SLogger::getStream()->error(__CLASS__);
        SLogger::getStream()->error(json_encode($banks));
        SLogger::getStream()->error(__CLASS__);

        return RestResponseFactory::ok($banks);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 修改默认银行卡
     */
    public function updateDefault(Request $request)
    {
        $data['userId'] = $this->getUserId($request);
        $data['userbankId'] = $request->input('userbankId');

        //设置默认储蓄卡责任链
        $card = new DoDefaultcardHandler($data);
        $res = $card->handleRequest();
        //错误提示
        if (isset($res['error'])) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), $res['error'], $res['code'], $res['error']);
        }

        return RestResponseFactory::ok(RestUtils::getStdObj());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 银行卡更新
     */
    public function update(Request $request)
    {
        return RestResponseFactory::ok();
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     * 基础信息 —— 获取支持银行列表
     */
    public function support()
    {
        $data = BankFactory::getBankLists();

        return RestResponseFactory::ok($data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 绑定银行卡获取个人信息
     */
    public function userInfo(Request $request){
        $user_id = $this->getUserId($request);
        $userInfo = UserRealnameFactory::fetchUserRealname($user_id);
        if(empty($userInfo)){
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1005), 1005);
        }
        $userInfo = [
            'real_name' => $userInfo['real_name'],
            'id_card_no' => $userInfo['id_card_no'],
        ];
        return RestResponseFactory::ok($userInfo);
    }

}