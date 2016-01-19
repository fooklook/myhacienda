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
			$table->increments('admin_id');
			$table->integer('auto_user_id');
			$table->integer('user_id');
			$table->smallInteger('user_power');
			$table->timestamp('created_time');
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
