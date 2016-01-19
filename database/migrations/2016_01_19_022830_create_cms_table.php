<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cms', function(Blueprint $table)
		{
			$table->increments('cms_id');
			$table->integer('cms_classify_id');		//���ܷ���
			$table->string('cms_name');				//��������
			$table->string('cms_route');			//����·��
			$table->smallInteger('cms_status');		//����״̬ 0Ϊ�رգ�1Ϊ��
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
		Schema::table('cms', function(Blueprint $table)
		{
			Schema::drop('cms');
		});
	}

}
