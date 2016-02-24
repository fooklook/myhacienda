<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleClassifyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('article_classify', function(Blueprint $table)
		{
			$table->increments('article_classify_id');
			$table->string('article_classify_name',60)->unique();
			$table->string('article_classify_path',60);
			$table->mediumText('article_classify_describe');
			$table->integer('article_classify_trunk_id');
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
		Schema::drop('article_classify');
	}

}
