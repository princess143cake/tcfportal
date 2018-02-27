	<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('production', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('production_product')->nullable();
			$table->string('production_customer')->nullable();
			$table->string('production_pack_size')->nullable();
			$table->string('production_product_size')->nullable();
			$table->string('production_cases')->nullable();
			$table->string('production_skids')->nullable();
			$table->string('production_shift')->nullable();
			$table->string('production_status')->nullable();
			$table->string('production_notes')->nullable();
			$table->integer('user_id')->nullable();
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
		Schema::drop('production');
	}

}
