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

Route::namespace('admin')->group(function () {
    Route::resource('shop', 'Admin\ShopController', ['only' => ['show', 'update', 'edit']]);
});

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/', 'HomeController@index')->name('home');
Route::any('/home', 'HomeController@upd');
Route::any('/home/show', 'HomeController@show');
