<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		DB::table('users')->insert([
	            'name' => 'Adrian',
	            'password' => Hash::make('abellanosa1998'),
		    'active' => 1,
			'is_admin' => 1,
		'username' => 'adrian'
        	]);
		// $this->call('UserTableSeeder');
	}

}
