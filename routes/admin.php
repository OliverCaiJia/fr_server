<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//登录退出
Route::group(['namespace' => 'Auth', 'as' => 'admin.'], function () {
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login')->name('login');
    Route::get('logout', 'LoginController@logout')->name('logout');
    Route::post('logout', 'LoginController@logout')->name('logout');
});

Route::group(['middleware' => ['auth:admin', 'menu', 'authAdmin'], 'as' => 'admin.'], function () {
    Route::get('/', function () {
        return view('admin');
    })->name('index');

    Route::get('main', function () {
        return view('admin.main');
    })->name('main');

    Route::any('changepsw', [
        'as' => 'changepsw',
        'uses' => 'Saas\UserController@changePsw',
    ]);

    Route::group(['namespace' => 'Saas', 'prefix' => 'saas'], function () {
        //用户设置相关
        Route::resource('person', 'UserController');
        Route::resource('role', 'RoleController');

        //账户管理
        Route::get('account', 'AccountController@index')->name('account.index');
    });

    //---------------------------- 账户管理 ----------------------------------//
    Route::group(['namespace' => 'Account', 'prefix' => 'account'], function () {
        //支付中心
        Route::resource('paymentaccount', 'PaymentAccountController');
        //用户账户信息
        Route::resource('useraccount', 'UserAccountController');
        //用户账户流水
        Route::resource('useraccountlog', 'UserAccountLogController');
    });

    //---------------------------- 数据管理 ----------------------------------//
    Route::group(['namespace' => 'Data', 'prefix' => 'data'], function () {
        //渠道统计
        Route::resource('channeldata', 'ChannelDataController');
        //产品统计
        Route::resource('productdata', 'ProductDataController');
    });


    //---------------------------- 配置中心 ----------------------------------//
    Route::group(['namespace' => 'Config', 'prefix' => 'config'], function () {
        //账户管理
        Route::resource('bannerconfig', 'BannerConfigController');
        //分享配置
        Route::resource('inviteconfig', 'InviteConfigController');
        //渠道配置
        Route::resource('channelconfig', 'ChannelConfigController');
    });

    //---------------------------- 短信中心 ----------------------------------//
    Route::group(['namespace' => 'Sms', 'prefix' => 'sms'], function () {
        //账户管理
        Route::resource('sms', 'SmsController');
        //短信配置
        Route::resource('smstype', 'SmsTypeController');
    });

    //---------------------------- 用户中心 ----------------------------------//
    Route::group(['namespace' => 'User', 'prefix' => 'user'], function () {

        //用户管理
        Route::resource('user', 'UserController');
        //用户个人信息
        Route::resource('userinfo', 'UserInfoController');
        //用户贷款流水
        Route::resource('userborrow', 'UserBorrowController');
        //用户邀请好友
        Route::resource('userinvite', 'UserInviteController');
        //用户邀请好友生成code
        Route::resource('userinvitecode', 'UserInviteCodeController');
        //用户贷款数据
        Route::resource('usertask', 'UserTaskController');
        //用户个人资料
        Route::resource('userbasic', 'UserBasicController');
    });

    //---------------------------- 报告管理 ----------------------------------//
    Route::group(['namespace' => 'Report', 'prefix' => 'report'], function () {
        //用户管理
        Route::resource('report', 'ReportController');
    });

    //---------------------------- 订单管理 ----------------------------------//
    Route::group(['namespace' => 'Order', 'prefix' => 'order'], function () {
        // 订单记录
        Route::any('', [
            'as' => 'order.index',
            'uses' => 'OrderController@index',
        ]);
        // 编辑页
        Route::any('edit/{id}', [
            'as' => 'order.edit',
            'uses' => 'OrderController@edit',
        ]);
        // 修改
        Route::any('update/{id}', [
            'as' => 'order.update',
            'uses' => 'OrderController@update',
        ]);
        // 已通过审核订单
        Route::any('passed', [
            'as' => 'order.passed',
            'uses' => 'OrderController@passed',
        ]);
        // 待处理订单
        Route::group(['prefix' => 'pending'], function () {
            Route::any('', [
                'as' => 'order.pending',
                'uses' => 'OrderController@pending',
            ]);
            // 通过
            Route::any('passOrder', [
                'as' => 'order.pending.detail.passOrder',
                'uses' => 'OrderController@passOrder',
            ]);
            // 拒绝
            Route::any('refuseOrder', [
                'as' => 'order.pending.detail.refuseOrder',
                'uses' => 'OrderController@refuseOrder',
            ]);
            // 分配订单
            Route::any('assign', [
                'as' => 'order.pending.assign',
                'uses' => 'OrderController@assign',
            ]);
            // 批量分配订单
            Route::any('batchAssign', [
                'as' => 'order.pending.batchAssign',
                'uses' => 'OrderController@batchAssign',
            ]);
        });
        //订单导入
        Route::post('import', 'OrderController@import')->name('order.import');
        //订单导入模板下载
        Route::get('template', 'OrderController@template')->name('order.download.template');

        //------复审放款-------
        Route::group(['prefix' => 'loan'], function () {
            //利率设置
            Route::any('', [
                'middleware' => ['valiAdmin:LoanIntRate'],
                'as' => 'order.loan.interest_rate',
                'uses' => 'LoanController@interestRate',
            ]);
            //立即放款
            Route::any('pass', [
                'middleware' => ['valiAdmin:LoanIntRate'],
                'as' => 'order.loan.pass',
                'uses' => 'LoanController@pass',
            ]);
            //拒绝放款
            Route::any('refuse', [
                'as' => 'order.loan.refuse',
                'uses' => 'LoanController@refuse',
            ]);
            //已拒绝放款
            Route::any('index', [
                'as' => 'order.loan.index',
                'uses' => 'LoanController@index',
            ]);
        });

        //还款管理
        Route::group(['prefix' => 'repaymanage'], function () {
            Route::any('repaying', [
                'as' => 'order.repaymanage.repaying',
                'uses' => 'OrderController@repaying',
            ]);
            Route::any('overduerepaying', [
                'as' => 'order.repaymanage.overduerepaying',
                'uses' => 'OrderController@overdueRepaying',
            ]);
            Route::any('repayed', [
                'as' => 'order.repaymanage.repayed',
                'uses' => 'OrderController@repayed',
            ]);
            Route::any('repaydetail', [
                'middleware' => ['valiAdmin:RepayDetail'],
                'as' => 'order.repaymanage.repaydetail',
                'uses' => 'OrderController@repayDetail',
            ]);
            Route::any('overduerepaydetail', [
                'middleware' => ['valiAdmin:OverdueRepayDetail'],
                'as' => 'order.repaymanage.overduerepaydetail',
                'uses' => 'OrderController@overdueRepayDetail',
            ]);
        });
    });
});
