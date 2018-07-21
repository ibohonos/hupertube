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
			$table->string('avatar')->default('storage/avatars/default.jpg');
			$table->boolean('active')->default('0');
			$table->string('api_token', 60)->unique();
			$table->string('github_token')->unique()->nullable();
			$table->string('facebook_token')->unique()->nullable();
			$table->string('linkedin_token')->unique()->nullable();
			$table->string('google_token')->unique()->nullable();
			$table->string('42_token')->unique()->nullable();
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
