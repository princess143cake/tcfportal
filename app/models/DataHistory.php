<?php

/**
* Data History
*/
class DataHistory extends Eloquent
{
	protected $table = 'data_history';
	protected $fillable = ['field','value'];
}