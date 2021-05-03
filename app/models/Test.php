<?php

/**
* Outbound Model
*/
class Test extends Eloquent
{


	protected $table = 'test';
	protected $fillable = [
		'type',
		'content'
	];

	
}
