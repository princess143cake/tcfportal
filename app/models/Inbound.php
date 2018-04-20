<?php

/**
* Inbound Model
*/
class Inbound extends Eloquent
{

	protected $table = 'inbound_schedule';
	protected $fillable = [
		'inbound_vendor',
		'inbound_po_number',
		'inbound_carrier',
		'inbound_product',
		'inbound_cases',
		'inbound_kg',
		'inbound_eta',
		'user_id',
		'inbound_container_number',
		'inbound_supplier',
		'inbound_steamship_provider',
		'inbound_arrival_to_port',
		'inbound_arrival_to_destination',
		'inbound_terminal_handling_fee_paid',
		'inbound_pickup_location',
		'inbound_pickup_appointment',
		'inbound_return_location',
		'inbound_rv_number',
		'inbound_pickup_number',
	];
	
}
