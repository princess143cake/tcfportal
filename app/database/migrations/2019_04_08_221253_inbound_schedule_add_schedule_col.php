<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InboundScheduleAddScheduleCol extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('inbound_schedule', function(Blueprint $table)
		{
			$table->string('schedule')->after('id')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('inbound_schedule', function(Blueprint $table)
		{
			$table->dropColumn('schedule');
		});
	}

}
