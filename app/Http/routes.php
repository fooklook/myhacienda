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
//��̨����
//Route::group(
//	['prefix'=>'admin'],function(){
//		//��̨��¼
//		//Route::controller('auth','AuthAdmin\AuthAdminController');
//	}
//);
//Route::grop(
//	['prefix'=>'article'],function(){
//		//���·���
//		//Route::controller('classify', '');
//		//�����б�
//		//Route::controller('list/{$id}', '');
//		//��������
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
