<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutboundScheduleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('outbound_schedule', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('outbound_carrier')->nullable();
			$table->string('outbound_driver')->nullable();
			$table->string('outbound_truck')->nullable();
			$table->bigInteger('outbound_start_time')->nullable();
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
		Schema::drop('outbound_schedule');
	}

}
