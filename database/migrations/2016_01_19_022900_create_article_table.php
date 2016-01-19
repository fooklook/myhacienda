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
			$table->increments('article_id');		//����id
			$table->integer('user_id');				//�û�id
			$table->string('article_title');		//���±���
			$table->mediumText('article_digest');	//����ժҪ
			$table->string('article_cover');		//���·���ͼƬ
			$table->text('article_content');		//��������
			$table->string('article_from');			//����ȡ��
			$table->smallInteger('article_status');	//����״̬
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
