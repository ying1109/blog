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

// web中间件从5.2.27版本以后默认全局加载，不需要自己手动载入，如果自己手动重复载入，会导致session无法加载
// Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return view('welcome');
    });

    Route::any('admin/login', 'Admin\LoginController@login');
    Route::get('admin/code', 'Admin\LoginController@code');
// });



Route::group(['middleware'=>['admin.login'], 'prefix'=>'admin', 'namespace'=>'Admin'], function () {
    Route::get('index', 'IndexController@index');
    Route::get('info', 'IndexController@info');
    Route::get('quit', 'LoginController@quit');
    Route::any('pass', 'IndexController@pass');

    Route::post('cate/changeOrder', 'CategoryController@changeOrder');
    Route::resource('category', 'CategoryController');
    Route::resource('article', 'ArticleController');
});




// 测试路由
Route::any('admin/connectionSql', 'Admin\TestController@connectionSql');
Route::any('admin/server', 'Admin\TestController@server');
Route::any('admin/crypt', 'Admin\TestController@crypt');