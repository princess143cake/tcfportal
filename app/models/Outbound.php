<?php

/**
* Outbound Model
*/
class Outbound extends Eloquent
{

	protected $table = 'outbound_schedule';
	protected $fillable = [
		'outbound_carrier',
		'outbound_driver',
		'outbound_truck',
		'outbound_start_time',
		'user_id',
		'outbound_region'
	];

	public function secondphase()
	{
		return $this->hasMany('OutboundSecond')->orderBy('sort_number', 'ASC');
	}
	
}
