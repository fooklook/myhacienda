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
Route::get('test',function(){
	\Illuminate\Support\Facades\Auth::loginUsingId(1);
	dd(\Illuminate\Support\Facades\Auth::user()->adminuser);
});
Route::post("/events", ["uses" => "HookController@storeEvents"]);

