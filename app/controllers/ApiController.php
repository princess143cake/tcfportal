<?php

/**
* api
*/
class ApiController extends BaseController
{
	
	public function getDataHistory()
	{
		$field = Input::get('field');
		return DataHistory::where(['field' => $field])->lists('value');
	}
	
}