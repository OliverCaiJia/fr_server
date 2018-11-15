<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\RestResponseFactory;
use App\Helpers\RestUtils;
use App\Http\Controllers\Controller;
use App\Models\Factory\Api\BankFactory;
use App\Models\Chain\UserBank\Add\DoAddHandler;
use App\Models\Factory\Api\UserBankcardFactory;
use Illuminate\Http\Request;
use App\Models\Chain\UserBank\Defaultcard\DoDefaultcardHandler;

/**
 * 银行卡设置
 */
class BanksController extends Controller
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
        $data['userId'] = $request->user()->id;
        //银行卡责任链
        $bankcard = new DoAddHandler($data);
        $res = $bankcard->handleRequest();
        //错误提示
        if (isset($res['error'])) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), $res['error'], $res['code'], $res['error']);
        }

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
        $userId = $request->user()->id;

        //用户绑定银行卡列表
        $userbanks['list'] = UserBankcardFactory::getUserBankList($userId);

        //暂无数据
        $cards = [];
        if (!empty($userbanks['list'])) {
            //获取银行信息，用户信息
            $cards = UserBankcardFactory::fetchUserbanksinfo($userbanks['list']);
        }
        $banks['list'] = $cards;

        return RestResponseFactory::ok($banks);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 修改默认银行卡
     */
    public function updateDefault(Request $request)
    {
        $data['userId'] = $request->user()->id;
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


}