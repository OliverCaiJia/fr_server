<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//'middleware' => ['auth:api'],
Route::group(['as' => 'api.'], function () {
    Route::get('/', function () {
        dd('sdfsdafasd');
        return view('admin');
    })->name('index');
});

