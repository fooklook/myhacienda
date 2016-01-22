<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admin_user', function(Blueprint $table)
		{
			$table->increments('admin_id');				//����Աid
			$table->integer('auto_user_id');			//��Ȩ�û�id
			$table->integer('user_id');					//�û�id
			$table->smallInteger('user_power');			//�û�Ȩ�� 7Ϊϵͳ����Ա��6Ϊ���������Ա��4Ϊ�������Ա��2Ϊ���¹���Ա��1Ϊ������˹���Ա��
			$table->timestamp('created_at');			//����ʱ��
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('admin_user', function(Blueprint $table)
		{
			Schema::drop('admin_user');
		});
	}

}
