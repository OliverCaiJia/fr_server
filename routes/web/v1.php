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
        $router->any('credit', ['middleware' => ['authWeb'],'uses' => 'AgreementController@credit']);
        // 
        $router->any('faceid', ['uses' => 'AgreementController@faceid']);
    }); 

    /**
     *   Invite API
     */
    $router->group(['prefix' => 'invite'], function ($router) {
        // 
        $router->any('home', ['uses' => 'InviteController@home']);
    }); 

    /**
     *   User API
     */
    $router->group(['prefix' => 'user'], function ($router) {
        // 
        $router->any('report', ['uses' => 'UserController@report']);
    }); 

});
