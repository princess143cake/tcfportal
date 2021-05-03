<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{


		for($i = 0; $i < 5; $i++){

			DB::table('inbound_schedule')->insert([

				'inbound_vendor' => str_random(10),
				'inbound_po_number' => str_random(10),
				'inbound_carrier' => str_random(10),
				'inbound_product' => str_random(10),
				'inbound_cases' => str_random(10),
				'inbound_kg' => 12,
				'inbound_eta' => 12,
				'user_id' => 1,
				'schedule' => '2021-04-22',
				'inbound_customer_po'  => str_random(10),
				'inbound_delivery_option'  => str_random(10),
				'created_at' => '2021-04-2',
				'updated_at' => '2021-04-2'
				
	
				// 'name' => str_random(10),
				// 'password' => Hash::make('secret'),
				// 'active' => 1,
				// 'is_admin' => 1,
				// 'username' => str_random(10)
			]);
			
		}

		
		// Eloquent::unguard();
		// DB::table('users')->insert([
	    //         'name' => 'Adrian',
	    //         'password' => Hash::make('abellanosa1998'),
		//     'active' => 1,
		// 	'is_admin' => 1,
		// 'username' => 'adrian'
        // 	]);
		// $this->call('UserTableSeeder');
	}

}
