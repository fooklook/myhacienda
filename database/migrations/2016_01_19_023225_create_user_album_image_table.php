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
			$table->increments('album_image_id');
			$table->integer('album_id');
			$table->string('image_src');
			$table->string('image_type');
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
		Schema::table('album_image', function(Blueprint $table)
		{
			Schema::drop('album_image');
		});
	}

}
