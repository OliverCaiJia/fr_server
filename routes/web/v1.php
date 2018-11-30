<?php
Route::group(['namespace' => 'V1','as' => 'web.','prefix' => 'v1'], function ($router) {
    Route::get('/', function () {
        return view('admin');
    })->name('index');

    /**
     *   Agreement API
     */
    $router->group(['prefix' => 'agreement'], function ($router) {
        // 
        $router->any('register', ['uses' => 'AgreementController@register']);
        //
        $router->any('credit', ['uses' => 'AgreementController@credit']);
        // 
        $router->any('faceid', ['uses' => 'AgreementController@faceid']);
    }); 

    /**
     *   Invite API
     */
    $router->group(['prefix' => 'invite'], function ($router) {
        // 
        $router->any('home', ['middleware' => ['authWeb'],'uses' => 'InviteController@home']);
    }); 

    /**
     *   User API
     */
    $router->group(['prefix' => 'user','middleware' => ['authWeb']], function ($router) {
        //获取信用报告
        $router->any('create/report',['uses' => 'UserController@createReport']);
        // 个人信用报告
        $router->any('report', ['uses' => 'UserController@report']);

        //个人资料列表
        $router->any('info/create', ['uses' => 'UserController@userinfo']);

    });

    /**
     * 支付
     */
    $router->group(['prefix' => 'payment'],function ($router) {
        $router->any('success', ['uses' => 'PaymentController@success']);
    });

    /**
     *  Wechat API
     */
    $router->group(['prefix' => 'invite'], function ($router) {//'middleware' => ['authWeb'],
        //生成好有链接
        $router->any('link', ['uses' => 'InviteController@link']);
        //生成邀请好友二维码
        $router->any('sqcode', ['uses' => 'InviteController@sqcode']);
        //邀请好友页面
        $router->any('home', ['uses' => 'InviteController@home']);

    });

    /**
     *  推荐服务
     */
    $router->group(['prefix' => 'cost'], function ($router) {
        //推荐服务/信用评估默认配置
        $router->any('costdefault', ['uses' => 'CostController@costDefault']);
    });

});
