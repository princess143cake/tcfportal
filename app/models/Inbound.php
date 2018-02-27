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
		'user_id'
	];
	
}
