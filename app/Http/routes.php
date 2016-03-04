<?php

/** 登录注册功能 **/
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
Route::get('create', 'HomeController@create');
Route::get('error404',function(){
	return view('errors.404');
});
Route::post("push","HookController@storeEvents");
Route::group(['prefix' => 'blog'],function(){
	Route::get('{classify}/{name}', 'BlogController@detail');
});
Route::get('email',function(){
	\Illuminate\Support\Facades\Queue::push(new \App\Commands\SendEmail('1013149199@qq.com'));
});
