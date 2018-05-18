<?php

/* All Auth routes / logged in */


// Operator Routes
Route::group(['before' => 'auth'], function() {

	//Outbound Schedule
	Route::get('outbound_schedule', ['before' => 'access_rights', 'uses' => 'OutboundController@index']);
	Route::post('outbound_schedule/insert', ['before' => 'csrf', 'uses' => 'OutboundController@insert']);
	Route::post('outbound_schedule/delete', ['before' => 'csrf', 'uses' => 'OutboundController@delete']);
	Route::post('outbound_schedule/edit', ['before' => 'csrf', 'uses' => 'OutboundController@edit']);
	Route::post('outbound_schedule/update', ['before' => 'csrf', 'uses' => 'OutboundController@update']);
	Route::post('outbound_schedule/sortNumber', ['before' => 'csrf', 'uses' => 'OutboundController@sortNumber']);
	//second phase
	Route::post('outbound_schedule/insert_stop', ['before' => 'csrf', 'uses' => 'OutboundController@insert_stop']);
	Route::post('outbound_schedule/delete_stop', ['before' => 'csrf', 'uses' => 'OutboundController@delete_stop']);
	Route::post('outbound_schedule/edit_stop', ['before' => 'csrf', 'uses' => 'OutboundController@edit_stop']);
	Route::post('outbound_schedule/update_stop', ['before' => 'csrf', 'uses' => 'OutboundController@update_stop']);

	//Inbound Schedule
	Route::get('inbound_schedule', ['before' => 'access_rights', 'uses' => 'InboundController@index']);
	Route::post('inbound_schedule/insert', ['before' => 'csrf', 'uses' => 'InboundController@insert']);
	Route::post('inbound_schedule/delete', ['before' => 'csrf', 'uses' => 'InboundController@delete']);
	Route::post('inbound_schedule/edit', ['before' => 'csrf', 'uses' => 'InboundController@edit']);
	Route::post('inbound_schedule/update', ['before' => 'csrf', 'uses' => 'InboundController@update']);

	//Inbound Shipping
	Route::get('inbound_shipping', ['before' => 'access_rights', 'uses' => 'InboundShippingController@index']);
	Route::post('inbound_shipping/insert', ['before' => 'csrf', 'uses' => 'InboundShippingController@insert']);
	Route::post('inbound_shipping/delete', ['before' => 'csrf', 'uses' => 'InboundShippingController@delete']);
	Route::post('inbound_shipping/edit', ['before' => 'csrf', 'uses' => 'InboundShippingController@edit']);
	Route::post('inbound_shipping/update', ['before' => 'csrf', 'uses' => 'InboundShippingController@update']);

	//Data History Api Request
	Route::post('api/getDataHistory', 'ApiController@getDataHistory');
	Route::get('data_history', ['before' => 'access_rights', 'uses' => 'MainController@data_history']);
	Route::post('data_history/delete', ['before' => 'csrf', 'uses' => 'MainController@delete_data_history']);
	Route::post('data_history/clear', ['before' => 'csrf', 'uses' => 'MainController@clear_data_history']);

	// production
	Route::get('production', ['before' => 'access_rights', 'uses' => 'ProductionController@production']);
	Route::get('production/weekly', ['before' => 'access_rights', 'uses' => 'ProductionController@productionWeekly']);
	//Route::match(array('GET', 'POST'), 'production','ProductionController@production');
	//Route::match(array('GET', 'POST'), 'production/weekly','ProductionController@productionWeekly');

	//Route::get('production', 'ProductionController@production');
	Route::post('production/addProduction', ['before' => 'csrf', 'uses' => 'ProductionController@addProduction']);
	Route::post('production/editProduction',['before' => 'csrf', 'uses' => 'ProductionController@editProduction']);
	Route::post('production/editProductionStatus',['before' => 'csrf', 'uses' => 'ProductionController@editProductionStatus']);
	Route::post('production/deleteProduction', ['before' => 'csrf', 'uses' => 'ProductionController@deleteProduction']);

	Route::post('manage_user/editSettings', ['before' => 'csrf', 'uses' => 'UserController@editSettings']);

	//fullscreen
	Route::get('fs/inbound', 'MainController@inbound_fullscreen');
	Route::get('fs/outbound', 'MainController@outbound_fullscreen');

	Route::get('fs/inbound_weekly', 'MainController@inbound_weekly_fullscreen');
	Route::get('fs/outbound_weekly', 'MainController@outbound_weekly_fullscreen');

	Route::get('fs/production_weekly', 'MainController@production_weekly_fullscreen');
	Route::get('fs/production_daily', 'MainController@production_daily_fullscreen');
});

// Admin Routes
Route::group(['before' => 'auth|admin'], function() {

	Route::get('test', function() {
		return 'test123';
	});

	Route::get('manage_user', 'UserController@index');
	Route::post('manage_user/addUser', ['before' => 'csrf', 'uses' => 'UserController@addUser']);
	Route::post('manage_user/deleteUser', ['before' => 'csrf', 'uses' => 'UserController@deleteUser']);
	Route::post('manage_user/editUser', ['before' => 'csrf', 'uses' => 'UserController@editUser']);

});