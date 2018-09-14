<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('email')->unique();
			$table->string('password');
			$table->string('avatar')->default('/storage/avatars/default.jpg');
			$table->boolean('active')->default('0');
			$table->string('github_id')->unique()->nullable();
			$table->string('facebook_id')->unique()->nullable();
			$table->string('google_id')->unique()->nullable();
			$table->string('intra_id')->unique()->nullable();
			$table->string('api_token', 60)->unique();
			$table->rememberToken();
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
		Schema::dropIfExists('users');
	}
}
