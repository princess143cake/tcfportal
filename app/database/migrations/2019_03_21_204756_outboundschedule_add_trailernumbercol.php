<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OutboundscheduleAddTrailernumbercol extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('outbound_schedule', function(Blueprint $table)
		{
			$table->string('outbound_trailer_number')->after('outbound_truck')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('outbound_schedule', function(Blueprint $table)
		{
			$table->dropColumn('outbound_trailer_number');
		});
	}

}
