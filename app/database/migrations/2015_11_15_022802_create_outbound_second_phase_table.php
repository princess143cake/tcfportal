<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutboundSecondPhaseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('outbound_second_phase', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('outbound_id');
			$table->bigInteger('outbound_dock_time')->nullable();
			$table->string('outbound_customer')->nullable();
			$table->string('outbound_location')->nullable();
			$table->string('outbound_order_number')->nullable();
			$table->string('outbound_pick_status')->nullable();
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
		Schema::drop('outbound_second_phase');
	}

}
