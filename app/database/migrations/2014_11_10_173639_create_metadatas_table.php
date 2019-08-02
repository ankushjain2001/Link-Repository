<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetadatasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('metadatas',function($table){
			$table->increments('id');
			$table->string('link');
			$table->string('heading');
			$table->string('category');
			$table->string('description');
			$table->string('photo');
			$table->bigInteger('counter');
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
		Schema::drop('metadatas');
	}

}
