<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('article', function(Blueprint $table)
		{
			$table->increments('article_id');		//文章id
			$table->integer('user_id');				//用户id
			$table->string('article_title');		//文章标题
			$table->mediumText('article_digest');	//文章摘要
			$table->string('article_cover');		//文章封面图片
			$table->text('article_content');		//文章内容
			$table->string('article_from');			//文章取自
			$table->smallInteger('article_status');	//文章状态
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
		Schema::table('article', function(Blueprint $table)
		{
			Schema::drop('article');
		});
	}

}
