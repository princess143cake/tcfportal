<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAccessRightsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_access_rights', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('action_rights_id');
			$table->integer('user_id');
			$table->string('grant');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_access_rights');
	}
}
