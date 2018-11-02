<?php
Route::group(['namespace' => 'V1','middleware' => ['authApi'],'as' => 'web.','prefix' => 'v1'], function () {
    Route::get('/', function () {
        return view('admin');
    })->name('index');

    Route::any('login', ['uses' => 'AuthController@login']);
});
