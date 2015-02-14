<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJudgementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('judgements', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('court');
			$table->integer('year');
			$table->string('case');
			$table->integer('no');
			$table->string('date', 7);
			$table->string('cause');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('judgements', function(Blueprint $table)
		{
			Schema::dropIfExists('judgements');
		});
	}

}
