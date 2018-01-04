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
Route::group(['middleware'=>'admin'],function (){
    //后台主页
    Route::get('/admin', 'Admin\IndexController@show');
//后台用户管理
    Route::get('/admin/user', 'Admin\UserController@show');
    Route::get('/admin/user/add', 'Admin\UserController@add');
    Route::get('/admin/user/edit/{uid?}', 'Admin\UserController@edit');
    Route::post('/admin/user/doadd', 'Admin\UserController@doadd');
    Route::post('/admin/user/doedit', 'Admin\UserController@doedit');

//后台商家设置
    Route::get('/admin/shop', 'Admin\ShopController@show');
    Route::get('/admin/shop/add', 'Admin\ShopController@add');
    Route::post('/admin/shop/doadd', 'Admin\ShopController@doadd');
    Route::get('/admin/shop/edit/{sid}', 'Admin\ShopController@edit')->name('shopEdit');
    Route::post('/admin/shop/doedit', 'Admin\ShopController@doedit');

//食物设置
    Route::get('/admin/food','Admin\FoodController@show');
    Route::get('/admin/food/edit/{fid?}','Admin\FoodController@edit');
    Route::get('/admin/food/add','Admin\FoodController@add');
    Route::post('/admin/food/doedit','Admin\FoodController@doedit');
    Route::post('/admin/food/doadd','Admin\FoodController@doadd');

//订单
    Route::get('/admin/order','Admin\OrderController@show');
    Route::get('/admin/allOrder','Admin\OrderController@allShow');
    //Route::get('/admin/order/search','Admin\OrderController@search');
//Route::get('/admin/order/allExport/{start?}/{end?}','Admin\OrderController@search');
    Route::get('/admin/order/export/{start?}/{end?}','Admin\OrderController@export');
    Route::get('/admin/order/shopexport/{start?}/{end?}','Admin\OrderController@shopExport');

//菜单设置
    Route::get('/admin/menu','Admin\MenuController@show')->name('menu');
    Route::get('/admin/menu/add/{sid?}','Admin\MenuController@add');
    Route::get('/admin/menu/edit/{mid?}','Admin\MenuController@edit');
    Route::post('/admin/menu/doadd','Admin\MenuController@doadd');
    Route::post('/admin/menu/doedit','Admin\MenuController@doedit');

    Route::get('/admin/menu/ajaxReq/{sid}','Admin\MenuController@ajaxReq');
    Route::get('/admin/menu/ajaxFind/{sid}/{tmark}','Admin\MenuController@fingMenuOfCurrentTime');

});

Route::group(['middleware'=>'shops'],function (){
    Route::get('/admin', 'Admin\IndexController@show')->name('admin');
    Route::get('/admin/myorder','Admin\OrderController@myOrder');
});
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index');
Route::any('/home/upd', 'HomeController@upd');
Route::any('/home/show', 'HomeController@show');

//导出到excel(测试用)
Route::get('excel/export','ExcelController@export');
Route::get('excel/import','ExcelController@import');

//前台用户
Route::get('user','UsersController@show');
Route::post('user/reset','UsersController@reset');

Auth::routes();

