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

//后台主页
Route::get('/admin', 'Admin\IndexController@show');
//后台用户管理
Route::get('/admin/user', 'Admin\UserController@show');

//后台商家设置
Route::get('/admin/shop', 'Admin\ShopController@show');
Route::get('/admin/shop/add', 'Admin\ShopController@add');
Route::post('/admin/shop/doadd', 'Admin\ShopController@doadd');
Route::get('/admin/shop/edit/{sid}', 'Admin\ShopController@edit')->name('shopEdit');
Route::post('/admin/shop/doedit', 'Admin\ShopController@doedit');

//食物设置
Route::get('/admin/food','Admin\FoodController@show');
Route::get('/admin/food/add','Admin\FoodController@add');
//订单
Route::get('/admin/order','Admin\OrderController@show');
//菜单设置
Route::get('/admin/menu','Admin\MenuController@show')->name('menu');
Route::get('/admin/menu/add/{sid?}','Admin\MenuController@add');
Route::post('/admin/menu/doadd','Admin\MenuController@doadd');
Route::get('/admin/menu/ajaxReq/{sid?}','Admin\MenuController@ajaxReq');



Route::get('/', 'HomeController@index')->name('home');
Route::any('/home', 'HomeController@index');
Route::any('/home/show', 'HomeController@show');

//导出到excel
Route::get('excel/export','ExcelController@export');
Route::get('excel/import','ExcelController@import');

Auth::routes();

