<?php
//首页
Route::get("/", "HomeController@index");
//博客
Route::group(['prefix' => 'blog'],function(){

	//列表页
	Route::get('{classify}', 'BlogController@listpage');
	//详细页
	Route::get('{classify}/{article}', 'BlogController@detailpage');

});
//Vue.js页面数据
Route::group(['prefix' => 'vue'],function(){
	//首页
	Route::get("/", "VueController@index");
	//列表页
	Route::get('{classify}', 'VueController@listpage');//第一页
	Route::get('{classify}/page/{page}', 'VueController@listpage');
	//详细页
	Route::get('{classify}/{article}', 'VueController@detailpage');

});
//github远程同步功能
Route::post("push","HookController@storeEvents");

/** 登录注册功能 **/
//Route::controllers([
//	'auth' => 'Auth\AuthController',
//	'password' => 'Auth\PasswordController',
//]);
//Route::get('create', 'HomeController@create');
//Route::get('error404',function(){
//	return view('errors.404');
//});
//Route::get('email',function(){
//	\Illuminate\Support\Facades\Queue::push(new \App\Commands\SendEmail('1013149199@qq.com'));
//});
