<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsClassifyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cms_classify', function(Blueprint $table)
		{
			$table->increments('cms_classify_id');
			$table->string('cms_classify_name');
			$table->string('cms_classify_route');
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
		Schema::table('cms_classify', function(Blueprint $table)
		{
			Schema::drop('cms_classify');
		});
	}

}
