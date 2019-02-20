<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::any('admin/index', 'Admin\IndexController@index');
Route::any('admin/info', 'Admin\IndexController@info');

Route::any('admin/login', 'Admin\LoginController@login');
Route::get('admin/code', 'Admin\LoginController@code');




// 测试路由
Route::any('admin/connectionSql', 'Admin\TestController@connectionSql');
Route::any('admin/server', 'Admin\TestController@server');