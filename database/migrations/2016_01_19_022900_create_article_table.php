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
			$table->integer('conn_type_id');		//�������� 1:html or 2:md
			$table->integer('user_id');				//�û�id
			$table->tinyInteger('article_classify_id');//分类id
			$table->string('article_title');		//���±���
			$table->mediumText('article_digest');	//����ժҪ
			$table->string('article_cover');		//���·���ͼƬ
			$table->text('article_content');		//��������
			$table->string('article_from');			//����ȡ��
			$table->smallInteger('article_status')->default('1');	//����״̬
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
