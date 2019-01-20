<?php
/**
 * Created by PhpStorm.
 * User: xxw1
 * Date: 18-12-5
 * Time: 下午2:00
 */

Route::group(['namespace' => 'V1','as' => 'qudao.','prefix' => 'v1'], function ($router) {
    Route::get('/', function () {
        return view('admin');
    })->name('index');
});