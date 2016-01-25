<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordMdTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('record_md', function(Blueprint $table)
		{
			$table->increments('record_md_id');
			$table->integer('user_id');
			$table->string('record_type',16);					//形式 1 导入 2更新
			$table->tinyInteger('record_status')->default(0);	//状态 0 失败 1成功
			$table->mediumText('record_remark');				//注释
			$table->timestamp('created_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('record_md');
	}

}
