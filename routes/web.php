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

//  -name('help') 是针对前端   route('help') 而 get('faq') 是针对url中 
Route::get('/','StaticPagesController@home')->name('home');
Route::get('/help','StaticPagesController@help')->name('help');
Route::get('/about','StaticPagesController@about')->name('about');
//注册路由
Route::get('/signup','UsersController@create')->name('signup');

//users 路由 
Route::resource('users','UsersController');//這行代碼 等同 下面
// 並且遵守  Resful架构对路由设计
/*Route::get('/users','UsersController@index')->name('users.index');
Route::get('/users/create','UsersController@create')->name('users.create');
Route::get('/users/{user}','UsersController@show')->name('users.show');
Route::post('/users','UsersController@store')->name('users.store');
Route::get('/users/{user}/edit','UsersController@edit')->name('user.edit');
Route::patch('/users/{user}','UsersController@update')->name('users.update');
Route::delete('/users/{user}','UsersController@destroy')->name('users.destroy');*/

/*Route::get($uri, $callback); 
Route::post($uri, $callback);
Route::put($uri, $callback);
Route::patch($uri, $callback);
Route::delete($uri, $callback);
Route::options($uri, $callback);*/
Route::get('login','SessionController@create')->name('login');
Route::post('login','SessionController@store')->name('login');
Route::delete('logout','SessionController@destroy')->name('logout');

//用户修改资料页面
Route::get('/users/{user}/edit','UsersController@edit')->name('users.edit');

//邮件激活 路由
Route::get('signup/confirm/{token}','UsersController@confirmEmail')->name('confirm_email');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// 微博 相关 路由
Route::resource('statuses','StatusesController',['only'=>['store','destroy']]);
