<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTagRelTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('article_tag_rel', function(Blueprint $table)
		{
			$table->increments('article_tag_rel_id');
			$table->integer('article_id');
			$table->integer('article_tag_id');
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
		Schema::table('article_tag_rel', function(Blueprint $table)
		{
			Schema::drop('article_tag_rel');
		});
	}

}
