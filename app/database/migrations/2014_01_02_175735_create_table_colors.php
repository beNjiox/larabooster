<?php

use Illuminate\Database\Migrations\Migration;

class CreateTableColors extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('colors', function($table)
		{
			$table->increments('id');
			$table->string('code')->unique();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('colors');
	}

}