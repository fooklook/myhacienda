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
//后台管理
//Route::group(
//	['prefix'=>'admin'],function(){
//		//后台登录
//		//Route::controller('auth','AuthAdmin\AuthAdminController');
//	}
//);
//Route::grop(
//	['prefix'=>'article'],function(){
//		//文章分类
//		//Route::controller('classify', '');
//		//文章列表
//		//Route::controller('list/{$id}', '');
//		//文章详情
//		//Route::controller('detail{$id}','');
//	}
//);
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
Route::get('error404',function(){
	return view('errors.404');
});
