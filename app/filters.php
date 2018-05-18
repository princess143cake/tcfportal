<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('/');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});


Route::filter('admin', function()
{
	if (Auth::user()->is_admin == 0) {
		return App::abort(404);
	}
});

Route::filter('access_rights', function($route,$request){
	//var_dump($route);
    if(Auth::user()->is_admin == 1) {
        return;
    }

    $access_rights = array("production" 	     => 1,
    					   "outbound_schedule"	 => 2,
    					   "inbound_schedule"	 => 3,
    					   "inbound_shipping"	 => 6,
    					   "data_history"		 => 4,
    					   "production-status"   => 5
    					  );

    $uri = Request::segment(1);
	$rights = UserAccessRights::where('user_id', '=', Auth::user()->id)->where('action_rights_id','=', $access_rights[$uri])->first();

	if($rights->grant == "false") {
		return Redirect::to('/');
	} else {
		return;
	}
});

/*
|--------------------------------------------------------------------------
| Source code minification
|--------------------------------------------------------------------------|
|
*/

App::after(function($request, $response)
{
	if(App::Environment() != 'local')
	{
		if($response instanceof Illuminate\Http\Response)
		{
			$output = $response->getOriginalContent();
			// Clean comments
			$output = preg_replace('/<!--([^\[|(<!)].*)/', '', $output);
			$output = preg_replace('/(?<!\S)\/\/\s*[^\r\n]*/', '', $output);
			// Clean Whitespace
			$output = preg_replace('/\s{2,}/', '', $output);
			$output = preg_replace('/(\r?\n)/', '', $output);
			$response->setContent($output);
		}
	}
});