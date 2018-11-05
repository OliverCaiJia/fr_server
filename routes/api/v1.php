<?php
Route::group(['namespace' => 'V1','middleware' => ['authApi'],'as' => 'api.','prefix' => 'v1'], function () {
    Route::get('/', function () {
        return view('admin');
    })->name('index');

    Route::any('login', ['middleware' => ['valiApi:abc'],'uses' => 'AuthController@login']);

    //创蓝短信test
    Route::any('test', ['uses' => 'TestController@sms']);
});
