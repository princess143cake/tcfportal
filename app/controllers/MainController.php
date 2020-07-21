<?php

class MainController extends BaseController {

	public function index()
	{
		
		if (Auth::check() && Auth::user()) {

			$current_date = date('l M j, Y');
			$is_admin 	  = false;

			if (Auth::user()->is_admin) {
				$is_admin = true;
			}

			//Operator View
			$production_count = Productions::where('created_at', 'like', date('Y-m-d').'%')->count();
			$outbound_count = Outbound::where('created_at', 'like', date('Y-m-d').'%')->count();
			$inbound_count = Inbound::where('created_at', 'like', date('Y-m-d').'%')->count();

			//get activities today
			$activities = Activity::where('created_at', 'like', date('Y-m-d').'%')->orderBy('id', 'desc')->get();

			return view('operator.index')->with(compact('current_date', 'production_count', 'outbound_count', 'inbound_count', 'activities', 'is_admin'));
		
		} else {
			return view('index');
		}
		
		
	}

	public function login()
	{
		$input =  Input::all();

		$user = $this->loginUser($input);

		//if login is correct
		if ($user['auth'] == 'valid') {
			
			Auth::login($user);

			return Redirect::to('/');

		} elseif ($user['auth'] == 'inactive') {
			// if account is not active
			return Redirect::back()->withErrors('Account not active.');
		} else {
			//if invalid credentials
			return Redirect::back()->withErrors('Invalid username or password.');
		}

	}

	public function logout()
	{
		Auth::logout();

		//redirect to login page
		return Redirect::to('/');
	}

	public function data_history()
	{
		$history = DataHistory::all();
		return view('operator.dataHistory')->with(compact('history'));
	}

	public function delete_data_history()
	{
		$ids = Input::get('ids');
		DataHistory::whereIn('id', $ids)->delete();
	}

	public function clear_data_history()
	{
		DataHistory::truncate();
	}

	public function inbound_fullscreen()
	{
		$date = date('l F j, Y');
		$today = date('Y-m-d');
		$nextday = date('Y-m-d', strtotime(' +1 day'));
		$hide_header = true;

		if (date('l', strtotime($today)) == "Friday") {
			$nextday = date('Y-m-d', strtotime(' +3 day'));
		}
		if (Input::has('d')) {
			$inbounds = Inbound::where('schedule', 'like', Input::get('d').'%')->get();
			$today = date('Y-m-d', strtotime(Input::get('d')));
			$date = date('l F j, Y', strtotime(Input::get('d')));
			//$nextday = date('Y-m-d', strtotime(Input::get('d').' +1 day'));
			$nextday = date('Y-m-d', strtotime(Input::get('d')));
		} else {
			$inbounds = Inbound::where('schedule', 'like', date('Y-m-d').'%')->get();
		}

		return view('fullscreen.inbound')->with(compact('inbounds', 'date', 'nextday','today', 'hide_header'));
	}


	public function outbound_fullscreen()
	{
		$date = date('l F j, Y');
		$today = date('Y-m-d');
		$nextday = date('Y-m-d', strtotime(' +1 day'));
		$hide_header = true;
/*
		if (date('l', strtotime($today)) == "Friday") {
			$nextday = date('Y-m-d', strtotime(' +3 day'));
		}
*/

		if (Input::has('d')) {
			$outbounds = Outbound::where('created_at', 'like', Input::get('d').'%')->orderBy('outbound_start_time', 'ASC')->get();
			$inbounds = Inbound::where('schedule', 'like', Input::get('d').'%')->get();
			$today = date('Y-m-d', strtotime(Input::get('d')));
			$date = date('l F j, Y', strtotime(Input::get('d')));
			$nextday = date('Y-m-d', strtotime(Input::get('d').' +1 day'));
		} else {
			$outbounds = Outbound::where('created_at', 'like', date('Y-m-d').'%')->orderBy('outbound_start_time', 'ASC')->get();
			$inbounds = Inbound::where('schedule', 'like', date('Y-m-d').'%')->get();
		}

		return view('fullscreen.outbound')->with(compact('inbounds','outbounds', 'date', 'nextday','today', 'hide_header'));
	}

	public function production_weekly_fullscreen()
	{
		$date 	     = date('l F j, Y');
		$max_row     = 0;
		$products    = array();
		$hide_header = true;
		$date_count  = 1;

		//$start_date = date("Y-m-d", strtotime($date . " +1 days"));
		$start_date = date("Y-m-d", strtotime($date));

		if(date('D', strtotime($start_date)) == 'Sat') {
			$start_date = date("Y-m-d", strtotime($date . " +3 days"));
		}

		if(date('D', strtotime($start_date)) == 'Sun') {
			$start_date = date("Y-m-d", strtotime($date . " +2 days"));
		}

		while($date_count <= 5) {
			$query = Productions::where('production_date', 'like', $start_date.'%')->get();

			if(date('D', strtotime($start_date)) == 'Sat') {
				$start_date = date("Y-m-d", strtotime($start_date . " +2 days"));
			}

			if(date('D', strtotime($start_date)) == 'Sun') {
				$start_date = date("Y-m-d", strtotime($start_date . " +1 days"));
			}

			if(!empty($query)) {
				if(count($query) > $max_row) {
					$max_row = count($query);
				}
			}

			$products[$start_date] = $query;
			$start_date 		   = date("Y-m-d", strtotime($start_date . " +1 days"));

			$date_count++;
		}

/* //old code
		if(date('D', strtotime($date)) == 'Mon') {
			$start_date = date("Y-m-d", strtotime($date));
		} else {
			$start_date = date("Y-m-d", strtotime("Previous Monday", strtotime($date)));
		}

		$end_date = date("Y-m-d", strtotime($start_date . " +4 days"));

		while ($start_date <= $end_date) {
			$query = Productions::where('production_date', 'like', $start_date.'%')->get();

			if(!empty($query)) {
				if(count($query) > $max_row) {
					$max_row = count($query);
				}
			}

			$products[$start_date] = $query;
			$start_date 		   = date("Y-m-d", strtotime($start_date ." + 1 days"));
		}
*/
		return view('fullscreen.production_weekly')->with(compact('products', 'date', 'max_row', 'hide_header'));
	}

	public function production_daily_fullscreen()
	{
		$date 		 = date('l F j, Y');
		$next_action = (!empty($_GET['next-action'])) ? $_GET['next-action'] : 'current day';
		$hide_header = true;

		if($next_action == 'next_day') {
			if(date('D', strtotime($date)) == 'Fri') {
				$date 		 = date( "Y-m-d",strtotime($date . " + 3 day"));
			} else {
				$date 		 = date( "Y-m-d",strtotime($date . " + 1 day"));
			}

			$next_action = "weekly";
		}

		$date = date('l F j, Y', strtotime($date));

		$products = Productions::where('production_date', 'like', date( "Y-m-d",strtotime($date)).'%')->get();
		return view('fullscreen.production_daily')->with(compact('products', 'date', 'next_action', 'hide_header'));
	}

	public function inbound_weekly_fullscreen() {
		$date 	     = date('l F j, Y');
		$max_row     = 0;
		$products    = array();
		$hide_header = true;
		$date_count  = 1;

		//$start_date = date("Y-m-d", strtotime($date . " +1 days"));
		$start_date = date("Y-m-d", strtotime($date));

		if(date('D', strtotime($start_date)) == 'Sat') {
			$start_date = date("Y-m-d", strtotime($date . " +3 days"));
		}

		if(date('D', strtotime($start_date)) == 'Sun') {
			$start_date = date("Y-m-d", strtotime($date . " +2 days"));
		}

		while($date_count <= 5) {
			$query = Inbound::where('created_at', 'like', $start_date.'%')->get();

			if(date('D', strtotime($start_date)) == 'Sat') {
				$start_date = date("Y-m-d", strtotime($start_date . " +2 days"));
			}

			if(date('D', strtotime($start_date)) == 'Sun') {
				$start_date = date("Y-m-d", strtotime($start_date . " +1 days"));
			}

			if(!empty($query)) {
				if(count($query) > $max_row) {
					$max_row = count($query);
				}
			}

			$products[$start_date] = $query;
			$start_date 		   = date("Y-m-d", strtotime($start_date . " +1 days"));

			$date_count++;
		}

/* //old code
		if(date('D', strtotime($date)) == 'Mon') {
			$start_date = date("Y-m-d", strtotime($date));
		} else {
			$start_date = date("Y-m-d", strtotime("Previous Monday", strtotime($date)));
		}

		$end_date = date("Y-m-d", strtotime($start_date . " +4 days"));

		while ($start_date <= $end_date) {
			$query = Productions::where('production_date', 'like', $start_date.'%')->get();

			if(!empty($query)) {
				if(count($query) > $max_row) {
					$max_row = count($query);
				}
			}

			$products[$start_date] = $query;
			$start_date 		   = date("Y-m-d", strtotime($start_date ." + 1 days"));
		}
*/
		return view('fullscreen.inbound_weekly')->with(compact('products', 'date', 'max_row', 'hide_header'));
	}

	public function outbound_weekly_fullscreen() {
		$date 	     = date('l F j, Y');
		$max_row     = 0;
		$products    = array();
		$hide_header = true;
		$date_count  = 1;

		//$start_date = date("Y-m-d", strtotime($date . " +1 days"));
		$start_date = date("Y-m-d", strtotime($date));
/*
		if(date('D', strtotime($start_date)) == 'Sat') {
			$start_date = date("Y-m-d", strtotime($date . " +3 days"));
		}

		if(date('D', strtotime($start_date)) == 'Sun') {
			$start_date = date("Y-m-d", strtotime($date . " +2 days"));
		}
*/
		while($date_count <= 5) {
			$query = Outbound::where('created_at', 'like', $start_date.'%')->get();
/*
			if(date('D', strtotime($start_date)) == 'Sat') {
				$start_date = date("Y-m-d", strtotime($start_date . " +2 days"));
			}

			if(date('D', strtotime($start_date)) == 'Sun') {
				$start_date = date("Y-m-d", strtotime($start_date . " +1 days"));
			}
*/
			if(!empty($query)) {
				if(count($query) > $max_row) {
					$max_row = count($query);
				}
			}

			$products[$start_date] = $query;
			$start_date 		   = date("Y-m-d", strtotime($start_date . " +1 days"));

			$date_count++;
		}

/* //old code
		if(date('D', strtotime($date)) == 'Mon') {
			$start_date = date("Y-m-d", strtotime($date));
		} else {
			$start_date = date("Y-m-d", strtotime("Previous Monday", strtotime($date)));
		}

		$end_date = date("Y-m-d", strtotime($start_date . " +4 days"));

		while ($start_date <= $end_date) {
			$query = Productions::where('production_date', 'like', $start_date.'%')->get();

			if(!empty($query)) {
				if(count($query) > $max_row) {
					$max_row = count($query);
				}
			}

			$products[$start_date] = $query;
			$start_date 		   = date("Y-m-d", strtotime($start_date ." + 1 days"));
		}
*/
		return view('fullscreen.outbound_weekly')->with(compact('products', 'date', 'max_row', 'hide_header'));
	}
}
