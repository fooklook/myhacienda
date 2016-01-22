<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAlbumImageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('album_image', function(Blueprint $table)
		{
			$table->increments('album_image_id');		//���ͼƬid
			$table->integer('album_id');				//���id
			$table->string('image_src')->unique();				//ͼƬ��ַ
			$table->string('image_alt');				//ͼƬ˵��
			$table->string('image_type');				//ͼƬ����
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
		Schema::table('album_image', function(Blueprint $table)
		{
			Schema::drop('album_image');
		});
	}

}
