<?php

/**
* Outbound Model
*/
class OutboundSecond extends Eloquent
{

	protected $table = 'outbound_second_phase';
	protected $fillable = [
		'outbound_id',
		'outbound_dock_time',
		'outbound_customer',
		'outbound_location',
		'outbound_order_number',
		'outbound_pick_status',
		'user_id',
		'outbound_skids'
	];

	public function outbound()
	{
		return $this->belongsTo('Outbound');
	}
	
}
