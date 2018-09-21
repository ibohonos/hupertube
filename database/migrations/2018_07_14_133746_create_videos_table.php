<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('videos', function (Blueprint $table) {
			$table->increments('id');
			$table->string('imdb_id', 30);
			$table->string('quality', 10);
			$table->text('video');
			$table->boolean('downloaded')->default(0);
			$table->timestamps();

			$table->unique(['imdb_id', 'quality']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('videos');
	}
}
