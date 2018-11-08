<?php
Route::group(['namespace' => 'V1','middleware' => ['authApi'],'as' => 'api.','prefix' => 'v1'], function ($router) {

    /**
     *   Auth API
     */
    $router->group(['prefix' => 'auth'], function ($router) {
        // 正常登陆
        $router->post('login', ['middleware' => ['valiApi:login'], 'uses' => 'AuthController@login']);
        //快捷注册
        $router->post('quicklogin', ['middleware' => ['valiApi:quicklogin'], 'uses' => 'AuthController@quickRegister']);
        // 用户退出
        $router->post('logout', ['uses' => 'AuthController@logout']);
    });

    /**
     *  Sms API
     */
    $router->group(['prefix' => 'sms'], function ($router) {
        //注册短信验证码
        $router->post('register', ['middleware' => ['valiApi:code'], 'uses' => 'SmsController@register']);
        //修改密码短信验证码
        $router->post('password', ['middleware' => ['valiApi:code'], 'uses' => 'SmsController@password']);
        //忘记密码
        $router->post('forgetPwd', ['middleware' => ['valiApi:code'], 'uses' => 'SmsController@forgetPwd']);
    });

    /**
     *  Users API
     */
    $router->group(['prefix' => 'user'], function ($router) {
        //***************** ********************
        //创建（忘记/修改）密码
        $router->post('updatepwd', ['middleware' => ['auth', 'valiApi:updatepwd'], 'uses' => 'UserController@updatePwd']);
        //用户个人信息获取
        $router->get('info', ['uses' => 'UserController@serInfo']);
        //个人资料查看
        $router->get('info/detail', ['uses' => 'UserinfoController@fetchCertifyinfo']);
        //个人资料提交/创建
        $router->post('info/create', [ 'uses' => 'UserinfoController@updateCertifyinfo']);
        //生成信用报告
        $router->get('report', ['uses' => 'UserinfoController@report']);

        //身份验证
        $router->group(['prefix' => 'verify'], function ($router) {
            // 检测和识别中华人民共和国第二代身份证正面
            $router->get('faceid/front', ['uses' => 'UserIdentityController@fetchFaceidToCardfrontInfo']);//'middleware' => ['auth', 'valiApi:idcardFront'],
            // 检测和识别中华人民共和国第二代身份证反面
            $router->get('faceid/back', ['uses' => 'UserIdentityController@fetchFaceidToCardbackInfo']);//'middleware' => ['auth', 'valiApi:idcardBack'],
            //天创验证身份证合法信息
            $router->post('tcredit', ['middleware' => ['auth'], 'uses' => 'UserIdentityController@checkIdcardFromTianchuang']);

        });

        //银行卡
        $router->group(['prefix' => 'payment'], function ($router) {
            //添加银行卡
            $router->post('card/add', ['middleware' => ['valiApi:bankId'], 'uses' => 'BanksController@add']);
            //银行卡校验
            $router->post('card/verify', ['middleware' => ['valiApi:bankId'],'uses' => 'BanksController@verify']);
            //银行卡删除
            $router->post('card/delete', ['uses' => 'BanksController@delete']);
            //银行卡列表
            $router->get('card/list', ['uses' => 'BanksController@list']);
            //修改默认银行卡
            $router->post('card/update/default', ['uses' => 'BanksController@updateDefault']);
            //支付确认页面
            $router->post('confirm', ['uses' => 'PaymentController@confirm']);
            //支付支持银行列表
            $router->get('bank/support', ['uses' => 'BanksController@support']);
        });

        //订单
        $router->group(['prefix' => 'order'], function ($router) {
            //订单列表
            $router->get('list',['uses' => 'OrderController@list']);
            //订单详情
            $router->get('info',['uses' => 'OrderController@info']);
            //创建订单
            $router->get('create',['uses' => 'OrderController@create']);
            //订单状态
            $router->get('status',['uses' => 'OrderController@status']);
        });

    });

    /**
     *  Wechat API
     */
    $router->group(['prefix' => 'invite'], function ($router) {
        //生成好有链接
        $router->post('link', ['uses' => 'InviteController@link']);
        //生成邀请好友二维码
        $router->post('sqcode', ['uses' => 'InviteController@sqcode']);
        //邀请好友页面
        $router->get('home', ['uses' => 'InviteController@home']);

    });

    /**
     *  banner
     */
    $router->group(['prefix' => 'banner'], function ($router) {
        //订单轮播图
        $router->get('oder', ['uses' => 'BannerController@order']);
        //信用报告轮播图
        $router->get('report', ['uses' => 'BannerController@report']);
        //首页轮播图
        $router->get('home', ['uses' => 'BannerController@home']);
        //推荐服务轮播图
        $router->get('groom', ['uses' => 'BannerController@groom']);

    });

    /**
     *  首页
     */
    $router->group(['prefix' => 'borrow'], function ($router) {
        //借款记录
        $router->get('home', ['uses' => 'BorrowController@home']);
        //首页默认配置
        $router->get('default', ['uses' => 'BorrowController@default']);
    });

    /**
     *  推荐服务
     */
    $router->group(['prefix' => 'groom'], function ($router) {
        //推荐服务默认配置
        $router->get('default', ['uses' => 'GroomController@default']);
    });

    /**
     *  我的协议
     */
    $router->group(['prefix' => 'agreement'], function ($router) {
        //注册协议
        $router->get('register', ['uses' => 'AgreementController@register']);
        //信用评估服务协议
        $router->get('credit', ['uses' => 'AgreementController@credit']);
        // face ID身份验证服务用户协议
        $router->get('faceid', ['uses' => 'AgreementController@faceid']);
    });

    /**
     *  版本检查
     */
    $router->group(['prefix' => 'version'], function ($router) {
        //注册协议
        $router->get('upgrade', ['uses' => 'VersionController@upgrade']);
    });

    /**
     *  贷款推送
     */
    $router->group(['prefix' => 'loan'], function ($router) {
        //推荐产品列表
        $router->get('products', ['uses' => 'LoanController@products']);
    });


});
