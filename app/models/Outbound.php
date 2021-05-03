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
		'outbound_region',
		'outbound_trailer_number'
	];

	public function secondphase()
	{
		return $this->hasMany('OutboundSecond')->orderBy('sort_number', 'ASC');
	}

	public function inbound()
	{
		return $this->belongsTo(Inbound::class);
	}
	// public function getCreatedAtAttribute($date)
	// {
	//     return Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('m/d/Y');
	// }

	// public function getUpdatedAtAttribute($date)
	// {
	//     return Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('m/d/Y');
	// }
}
