<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/401', function () {
    return view('errors.401');
})->name('401');


foreach (File::allFiles(__DIR__ . '/web') as $partial)
{
    require_once $partial->getPathname();
}
