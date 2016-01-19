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
			$table->integer('auto_admin_id');	//授权管理员id
			$table->integer('cms_id');			//授权功能
			$table->integer('admin_id');		//被授权管理员id
			$table->smallInteger('admin_cms_status');	//授权功能状态 0为关闭，1为打开
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
