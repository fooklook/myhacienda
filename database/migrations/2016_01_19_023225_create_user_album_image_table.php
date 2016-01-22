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
			$table->increments('album_image_id');		//相册图片id
			$table->integer('album_id');				//相册id
			$table->string('image_src')->unique();				//图片地址
			$table->string('image_alt');				//图片说明
			$table->string('image_type');				//图片类型
			$table->timestamp('created_at');			//创建时间
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
