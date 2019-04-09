<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InboundscheduleAddnewCols extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('inbound_schedule', function(Blueprint $table)
		{
			$table->string('inbound_customer_po')->after('schedule')->nullable();
			$table->string('inbound_delivery_option')->after('inbound_customer_po')->nullable();
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
			$table->dropColumn('inbound_customer_po');
			$table->dropColumn('inbound_delivery_option');
		});
	}

}
