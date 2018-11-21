<?php
Route::group(['namespace' => 'V1', 'middleware' => ['sign'], 'as' => 'api.', 'prefix' => 'v1'], function ($router) {
    
    /**
     *   Auth API
     */
    $router->group(['prefix' => 'auth'], function ($router) {
        // 正常登陆
        $router->any('login', ['middleware' => ['valiApi:login'], 'uses' => 'AuthController@login']);
        //快捷注册
        $router->any('quicklogin', ['middleware' => ['valiApi:quicklogin'], 'uses' => 'AuthController@quickLogin']);
        // 用户退出
        $router->any('logout', ['middleware' => ['authApi'], 'uses' => 'AuthController@logout']);
    });

    /**
     *  Sms API
     */
    $router->group(['prefix' => 'sms'], function ($router) {
        //注册短信验证码
        $router->any('register', ['middleware' => ['valiApi:code'], 'uses' => 'SmsController@register']);
        //修改密码短信验证码
        $router->any('password', ['middleware' => ['authApi'], 'uses' => 'SmsController@password']);//添加验证器
        //忘记密码
        $router->any('forgetpwd', ['uses' => 'SmsController@forgetPwd']);//添加验证器
    });

    /**
     *  Users API
     */
    $router->group(['prefix' => 'user', 'middleware' => ['authApi']], function ($router) {
        //***************** ********************
        //创建（忘记/修改）密码
        $router->any('updatepwd', ['uses' => 'UserController@updatePwd']);//添加验证器
        //用户个人信息获取
        $router->any('info', ['uses' => 'UserController@serInfo']);
        //个人资料查看
        $router->any('info/detail', ['uses' => 'UserinfoController@fetchCertifyinfo']);
        //个人资料提交/创建
        $router->any('info/create', ['middleware' => ['valiApi:UserInfo'], 'uses' => 'UserinfoController@updateCertifyinfo']);//添加验证器
        //生成信用报告
        $router->any('report', ['uses' => 'UserinfoController@report']);//添加验证器

        //身份验证
        $router->group(['prefix' => 'verify'], function ($router) {
            // 检测和识别中华人民共和国第二代身份证正面
            $router->get('faceid/front', ['uses' => 'UserIdentityController@fetchFaceidToCardfrontInfo']);//'middleware' => ['auth', 'valiApi:idcardFront'],
            // 检测和识别中华人民共和国第二代身份证反面
            $router->get('faceid/back', ['uses' => 'UserIdentityController@fetchFaceidToCardbackInfo']);//'middleware' => ['auth', 'valiApi:idcardBack'],
            //天创验证身份证合法信息
            $router->any('tcredit', ['uses' => 'UserIdentityController@checkIdcardFromTianchuang']);//添加验证器

        });

        //银行卡
        $router->group(['prefix' => 'payment'], function ($router) {
            //添加银行卡
            $router->any('card/bank/create', ['middleware' => ['valiApi:bank'], 'uses' => 'BanksController@createUserBank']);
            //银行卡删除
            $router->any('card/delete', ['uses' => 'BanksController@delete']);//添加验证器
            //银行卡列表
            $router->any('card/banks', ['uses' => 'BanksController@fetchUserBanks']);
            //修改默认银行卡
            $router->any('card/default', ['middleware' => ['valiApi:userbankId'], 'uses' => 'BanksController@updateDefault']);
            //绑定银行卡获取个人信息
            $router->any('card/user/info', ['uses' => 'BanksController@userInfo']);
            //支付确认页面
            $router->any('confirm', ['uses' => 'PaymentController@confirm']);
            //支付支持银行列表
            $router->any('card/bank/support', ['uses' => 'BanksController@support']);
            //同步回调
            $router->any('yibao/sync', ['uses' => 'YiBaoController@sync']);//添加验证器
            //异步回调
            $router->any('yibao/async', ['uses' => 'YiBaoController@async']);//添加验证器
        });

        //订单
        $router->group(['prefix' => 'order'], function ($router) {
            //订单列表
            $router->post('list', ['middleware' => ['valiApi:userOrderList'], 'uses' => 'UserOrderController@list']);//添加验证器
            //订单详情
            $router->post('info', ['middleware' => ['valiApi:userOrderInfo'], 'uses' => 'UserOrderController@info']);
            //创建订单
            $router->post('create', ['middleware' => ['valiApi:createOrder'], 'uses' => 'UserOrderController@create']);
            //订单状态
            $router->post('status', ['middleware' => ['valiApi:userOrderStatus'], 'uses' => 'UserOrderController@getStatus']);

            $router->get('report', [ 'uses' => 'UserOrderController@report']);
            //订单状态
            $router->post('extra', [ 'uses' => 'UserOrderController@extra']);

        });

        //账户信息
        $router->group(['prefix' => 'account'], function ($router) {
            //邀请好友信息列表
//            $router->any('invitecount', ['uses' => 'AccountController@inviteAccount']);
            //账户信息
            $router->any('info', ['uses' => 'AccountController@info']);
        });
    });


    /**
     *  banner
     */
    $router->group(['prefix' => 'banner'], function ($router) {//添加验证器
        //订单轮播图
        $router->any('oder', ['uses' => 'BannerController@order']);
        //信用报告轮播图
        $router->any('report', ['uses' => 'BannerController@report']);
        //首页轮播图
        $router->any('home', ['uses' => 'BannerController@home']);
        //推荐服务轮播图
        $router->any('groom', ['uses' => 'BannerController@groom']);

    });

    /**
     *  首页
     */
    $router->group(['prefix' => 'borrow'], function ($router) {
        //借款记录
        $router->any('home', ['uses' => 'BorrowController@home']);
        //首页默认配置
        $router->any('default', ['uses' => 'BorrowController@default']);
    });

    /**
     *  推荐服务
     */
    $router->group(['prefix' => 'cost', 'middleware' => ['authApi']], function ($router) {
        //推荐服务/信用评估默认配置
        $router->any('costdefault', ['uses' => 'CostController@costDefault']);
    });

    /**
     *  版本检查
     */
    $router->group(['prefix' => 'version', 'middleware' => ['authApi']], function ($router) {
        //android 版本升级
        $router->post('android', ['middleware' => ['valiApi:upgrade'], 'uses' => 'VersionController@upgradeAndroid']);
        //ios 版本升级
        $router->post('ios', ['middleware' => ['valiApi:upgrade'], 'uses' => 'VersionController@upgradeIos']);
    });

    /**
     *  贷款推送
     */
    $router->group(['prefix' => 'loan', 'middleware' => ['authApi']], function ($router) {
        //推荐产品列表
        $router->any('products', ['middleware' => ['valiApi:loan'],'uses' => 'LoanController@products']);//添加验证器
    });

    /**
     * 微信 sdk
     */
    $router->group(['prefix' => 'wechat', 'middleware' => ['authApi']], function ($router) {
        //水果贷 分享
        $router->post('', ['uses' => 'WechatController@fetchSignPackage']);
    });

    /**
     * 分享链接
     */
    $router->group(['prefix' => 'invite', 'middleware' => ['authApi']], function ($router) {
        //用户邀请链接
        $router->get('link', ['uses' => 'InviteController@link']);
        //生成验证码
        $router->get('qrcode', ['uses' => 'InviteController@sqcode']);
    });

    /**
     *  Test API（调试）
     */
    $router->group(['prefix' => 'test'], function ($router) {
//        $router->any('product', ['uses' => 'TestController@product']);
        $router->any('doReport', ['uses' => 'TestController@doReport']);
        $router->any('doApply', ['uses' => 'TestController@doApply']);
    });

    /**
     * 报告回调
     */
    $router->group(['prefix' => 'report'], function ($router) {
        $router->any('create', ['uses' => 'ReportCallbackController@create']);
    });
});
