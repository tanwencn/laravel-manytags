<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTermsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('terms', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('parent_id')->unsigned()->default(0)->index('parent_id');
			$table->string('title', 80)->default('');
			$table->string('slug', 80)->default('')->index('slug');
			$table->string('taxonomy', 32)->default('')->index('taxonomy');
			$table->smallInteger('order')->unsigned()->default(99)->index('order');
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
		Schema::drop('terms');
	}

}
