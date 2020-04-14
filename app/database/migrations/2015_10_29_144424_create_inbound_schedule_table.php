<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInboundScheduleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inbound_schedule', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('inbound_vendor')->nullable();
			$table->string('inbound_po_number')->nullable();
			$table->string('inbound_carrier')->nullable();
			$table->string('inbound_product')->nullable();
			$table->integer('inbound_cases')->nullable();
			$table->integer('inbound_kg')->nullable();
			$table->bigInteger('inbound_eta')->nullable();
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
		Schema::drop('inbound_schedule');
	}

}
