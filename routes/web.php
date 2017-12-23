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

//后台商家设置
Route::get('/admin/shop', 'Admin\ShopController@show');
Route::get('/admin/shop/add', 'Admin\ShopController@add');
Route::post('/admin/shop/doadd', 'Admin\ShopController@doadd');

//食物设置
Route::get('/admin/food','Admin\FoodController@show');
Route::get('/admin/food/add','Admin\FoodController@add');
//食物设置
Route::get('/admin/order','Admin\OrderController@show');

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
