<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user', function(Blueprint $table)
		{
			$table->increments('user_id');
			$table->string('user_avatars')->default('/aravats.jpg');		//用户头像
			$table->string('user_name',60)->unique();						//用户名
			$table->string('user_nickname',60)->unique();					//用户昵称
			$table->string('user_email',60)->unique();						//用户邮箱地址
			$table->string('user_password', 60);							//用户密码，改为md5加密
			$table->string('login_ip',16);									//登录ip地址
			$table->rememberToken();										//token
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
		Schema::drop('user');
	}

}
