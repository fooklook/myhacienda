<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAlbumTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('album', function(Blueprint $table)
		{
			$table->increments('album_id');				//相册id
			$table->integer('user_id');					//用户id
			$table->string('album_name', 120);				//相册名
			$table->mediumText('album_describe');				//相册描述
			$table->string('album_cover');				//相册封面
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
		Schema::table('album', function(Blueprint $table)
		{
			Schema::drop('album');
		});
	}

}
