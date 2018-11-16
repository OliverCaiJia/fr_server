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
        $router->any('logout', ['uses' => 'AuthController@logout']);//添加验证器
    });

    /**
     *  Sms API
     */
    $router->group(['prefix' => 'sms'], function ($router) {
        //注册短信验证码
        $router->any('register', ['middleware' => ['valiApi:code'], 'uses' => 'SmsController@register']);
        //修改密码短信验证码
        $router->any('password', ['uses' => 'SmsController@password']);//添加验证器
        //忘记密码
        $router->any('forgetPwd', ['uses' => 'SmsController@forgetPwd']);//添加验证器
    });

    /**
     *  Users API
     */
    $router->group(['prefix' => 'user','middleware' => ['authApi']], function ($router) {
        //***************** ********************
        //创建（忘记/修改）密码
        $router->any('updatepwd', ['uses' => 'UserController@updatePwd']);//添加验证器
        //用户个人信息获取
        $router->any('info', ['uses' => 'UserController@serInfo']);
        //个人资料查看
        $router->any('info/detail', ['uses' => 'UserinfoController@fetchCertifyinfo']);
        //个人资料提交/创建
        $router->any('info/create', ['uses' => 'UserinfoController@updateCertifyinfo']);//添加验证器
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
            $router->any('card/createUserBank', [ 'uses' => 'BanksController@createUserBank']);//添加验证器
            //银行卡校验
            $router->any('card/verify', ['uses' => 'BanksController@verify']);//添加验证器
            //银行卡删除
            $router->any('card/delete', ['uses' => 'BanksController@delete']);//添加验证器
            //银行卡列表
            $router->any('card/fetchUserBanks', ['middleware' => ['authApi'], 'uses' => 'BanksController@fetchUserBanks']);//添加验证器
            //修改默认银行卡
            $router->any('card/updateDefault', ['middleware' => ['authApi'], 'uses' => 'BanksController@updateDefault']);//添加验证器
            //支付确认页面
            $router->any('confirm', ['uses' => 'PaymentController@confirm']);
            //支付支持银行列表
            $router->any('bank/support', ['uses' => 'BanksController@support']);
            //同步回调
            $router->any('yibao/sync', ['uses' => 'YiBaoController@sync']);//添加验证器
            //异步回调
            $router->any('yibao/async', ['uses' => 'YiBaoController@async']);//添加验证器
        });

        //订单
        $router->group(['prefix' => 'order','middleware' => ['authApi']], function ($router) {
            //订单列表
            $router->any('list', ['uses' => 'UserOrderController@list']);//添加验证器
            //订单详情
            $router->any('info', ['uses' => 'UserOrderController@info']);
            //创建订单
            $router->get('create', ['middleware' => ['valiApi:createOrder'], 'uses' => 'UserOrderController@create']);
            //订单状态
            $router->any('status', ['uses' => 'UserOrderController@status']);
            //订单状态  测试支付回调使用
            //$router->any('update', ['uses' => 'UserOrderController@update']);
        });

        //账户信息
        $router->group(['prefix' => 'account'], function ($router) {
            //邀请好友信息列表
            $router->any('invitecount', [ 'uses' => 'AccountController@inviteAccount']);
            //账户信息
            $router->any('info', ['uses' => 'AccountController@info']);
        });
    });

    /**
     *  Wechat API
     */
    $router->group(['prefix' => 'invite','middleware' => ['authApi']], function ($router) {
        //生成好有链接
        $router->any('link', ['uses' => 'InviteController@link']);
        //生成邀请好友二维码
        $router->any('sqcode', ['uses' => 'InviteController@sqcode']);
        //邀请好友页面
        $router->any('home', ['uses' => 'InviteController@home']);

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
    $router->group(['prefix' => 'cost','middleware' => ['authApi']], function ($router) {
        //推荐服务/信用评估默认配置
        $router->any('costdefault', ['uses' => 'CostController@costDefault']);
    });

    /**
     *  我的协议
     */
    $router->group(['prefix' => 'agreement'], function ($router) {
        //注册协议
        $router->any('register', ['uses' => 'AgreementController@register']);
        //信用评估服务协议
        $router->any('credit', ['uses' => 'AgreementController@credit']);
        // face ID身份验证服务用户协议
        $router->any('faceid', ['uses' => 'AgreementController@faceid']);
    });

    /**
     *  版本检查
     */
    $router->group(['prefix' => 'version'], function ($router) {
        //注册协议
        $router->any('upgrade', ['uses' => 'VersionController@upgrade']);//添加验证器
    });

    /**
     *  贷款推送
     */
    $router->group(['prefix' => 'loan','middleware' => ['authApi']], function ($router) {
        //推荐产品列表
        $router->any('products', ['uses' => 'LoanController@products']);//添加验证器
    });

    /**
     *  Test API（调试）
     */
    $router->group(['prefix' => 'test'], function ($router) {
        $router->any('yibao', ['uses' => 'TestController@orderPay']);
    });
});
