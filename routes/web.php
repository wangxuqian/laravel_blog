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


Route::group(['prefix' => 'admin','namespace' => 'admin','middleware' => [] ], function () {
    Route::any('login', 'LoginController@login');
    Route::get('code', 'LoginController@code');
});


Route::group(['prefix' => 'admin','namespace' => 'admin','middleware' => ['web','admin.login'] ], function () {
    Route::any('', 'IndexController@index');
    Route::get('index', 'IndexController@index');
    Route::get('info', 'IndexController@info');
    Route::get('gettest', 'IndexController@gettest');
    Route::get('destory_login', 'LoginController@destory_login');
    Route::any('password_update', 'LoginController@password_update');
    Route::resource('category','CategoryController');
    Route::any('category/changeorder', 'CategoryController@changeorder');
    Route::resource('article','ArticleController');
    Route::any('upload','CommonController@upload');
});


