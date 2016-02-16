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
			$table->string('user_avatars')->default('/aravats.jpg');		//�û�ͷ��
			$table->string('user_name',60)->unique();						//�û���
			$table->string('user_nickname',60)->unique();					//�û��ǳ�
			$table->string('user_email',60);						//�û������ַ
			$table->string('user_phone',11);
			$table->string('user_password', 60);							//�û����룬��Ϊmd5����
			$table->string('login_ip',16);									//��¼ip��ַ
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
