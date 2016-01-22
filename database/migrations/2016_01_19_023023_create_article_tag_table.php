<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTagTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('article_tag', function(Blueprint $table)
		{
			$table->increments('article_tag_id');		//���±�ǩid
			$table->string('article_tag_name');			//���±�ǩ
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
		Schema::table('article_tag', function(Blueprint $table)
		{
			Schema::drop('article_tag');
		});
	}

}
