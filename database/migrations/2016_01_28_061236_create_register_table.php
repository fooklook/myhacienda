<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegisterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('register', function(Blueprint $table)
		{
			$table->increments('register_id');
			$table->string('user_email')->unique();				//注册邮箱
			$table->string('user_phone',11)->unique();			//手机号码
			$table->string('user_password');					//注册密码
			$table->string('user_token',10);					//注册验证码
			$table->string('user_again_token',10);					//注册验证码
			$table->tinyInteger('count')->default(1);						//发送邮件的次数
			$table->tinyInteger('status')->default(0);				//注册状态 0为未验证，1为验证
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('register');
	}

}
