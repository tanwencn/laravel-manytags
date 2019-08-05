<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTermablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('termables', function(Blueprint $table)
		{
			$table->bigInteger('term_id')->unsigned();
			$table->bigInteger('termable_id')->unsigned()->index('termable_id');
			$table->string('termable_type', 191);
			$table->unique(['term_id','termable_id','termable_type'], 'term_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('termables');
	}

}
