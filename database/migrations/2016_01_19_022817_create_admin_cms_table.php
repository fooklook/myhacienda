<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminCmsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admin_cms', function(Blueprint $table)
		{
			$table->increments('admin_cms_id');
			$table->integer('auto_admin_id');	//��Ȩ����Աid
			$table->integer('cms_id');			//��Ȩ����
			$table->integer('admin_id');		//����Ȩ����Աid
			$table->smallInteger('admin_cms_status');	//��Ȩ����״̬ 0Ϊ�رգ�1Ϊ��
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
		Schema::table('admin_cms', function(Blueprint $table)
		{
			Schema::drop('admin_cms');
		});
	}

}
