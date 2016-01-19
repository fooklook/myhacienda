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
			$table->integer('cms_classify_id');		//功能分类
			$table->string('cms_name');				//功能名称
			$table->string('cms_route');			//功能路由
			$table->smallInteger('cms_status');		//功能状态 0为关闭，1为打开
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
