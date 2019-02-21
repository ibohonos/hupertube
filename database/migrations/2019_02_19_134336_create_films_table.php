<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilmsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('films', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title_en');
			$table->string('title_ru');
			$table->string('title_uk');
			$table->string('poster_en');
			$table->string('poster_ru');
			$table->string('poster_uk');
			$table->string('cover_en');
			$table->string('cover_ru');
			$table->string('cover_uk');
			$table->text('desc_en');
			$table->text('desc_ru');
			$table->text('desc_uk');
			$table->string('rating');
			$table->string('date');
			$table->string('time');
			$table->string('imdb_id')->unique();
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
		Schema::dropIfExists('films');
	}
}
