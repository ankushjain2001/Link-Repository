<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoogleusersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('googleusers',function($table){

			$table->decimal('google_id',21,0)->unique()->primary();
			$table->string('name');
			$table->string('google_email');
			$table->string('google_link');
			$table->string('google_picture_link');
			$table->string('loggedin');
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
		Schema::drop('googleusers');
	}

}
