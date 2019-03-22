<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductionAddNewCols extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('production', function(Blueprint $table)
		{
			$table->string('production_customer_po')->after('production_customer')->nullable();
			$table->string('production_delivery_option')->after('production_customer_po')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('production', function(Blueprint $table)
		{
			$table->dropColumn('production_customer_po');
			$table->dropColumn('production_delivery_option');
		});
	}

}
