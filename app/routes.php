<?php

/**
 * Application Routes
 */


Route::get('/', 'MainController@index');

Route::post('login', 'MainController@login');
Route::get('logout', 'MainController@logout');

Route::get('create_user', function()
{
	User::create([
		'username' => 'admin',
		'password' => Hash::make('Tcf@dm1n'),
		'name'     => 'Administrator',
        'is_admin' => 1
	]);
	return 'done';
});

Route::get('create_access_rights', function()
{
    $rights = array(array('id'     => 1,
                          'title'  => 'production_schedule',
                          'action' => 'production'),
                    array(
                         'id'     => 2,
                         'title'  => 'outbound_schedule',
                         'action' => 'outbound'),
                    array('id'     => 3,
                          'title'  => 'inbound_schedule',
                          'action' => 'production'),

                    
                    array('id'     => 4,
                          'title'  => 'production-status',
                          'action' => 'production'
                         ),
                    array('id'     => 5,
                          'title'  => 'date_history',
                          'action' => 'history'),
                    array('id'     => 6,
                          'title'  => 'inbound_shipping',
                          'action' => 'production'),

                    );

    foreach($rights as $key => $value) {
        AccessRights::firstOrCreate($value);
    }

    return 'done';
});

// Include Groups
include(app_path().'/groupRoutes.php');

  Route::get('fsf/inbound', 'MainController@inbound_fullscreen');
  Route::get('fsf/outbound', 'MainController@outbound_fullscreen');
  Route::get('fsf/production_weekly', 'MainController@production_weekly_fullscreen');
  Route::get('fsf/production_daily', 'MainController@production_daily_fullscreen');
  Route::get('fsf/outbound_weekly', 'MainController@outbound_weekly_fullscreen');
  Route::get('fsf/inbound_weekly', 'MainController@inbound_weekly_fullscreen');

  Route::get('fsf/inbound_v2', 'MainController@inbound_fullscreen');
  Route::get('fsf/outbound_v2', 'MainController@outbound_fullscreen');
  Route::get('fsf/production_weekly_v2', 'MainController@production_weekly_fullscreen');
  Route::get('fsf/production_daily_v2', 'MainController@production_daily_fullscreen');
