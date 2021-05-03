<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInboundedToInboundedSchedule extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('inbound_schedule', function (Blueprint $table) {
			$table->string('inbounded')->after('updated_at')->default('Inbound');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('inbound_schedule', function (Blueprint $table) {
			$table->dropColumn('inbounded');
		});
	}
}