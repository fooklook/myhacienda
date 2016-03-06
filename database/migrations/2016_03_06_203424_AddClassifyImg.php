<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClassifyImg extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('article_classify', function(Blueprint $table)
		{
			$table->string('article_classify_cover')->default('http://7xo7bi.com1.z0.glb.clouddn.com/note-easybuild.jpg')->after('article_classify_name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('article_classify', function(Blueprint $table){
			$table->dropColumn('article_classify_cover');
		});
	}

}
