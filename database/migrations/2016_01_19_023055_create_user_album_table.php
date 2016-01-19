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
			$table->increments('album_id');
			$table->integer('user_id');
			$table->string('album_name');
			$table->text('album_describe');
			$table->string('album_cover');
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
