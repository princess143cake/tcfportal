<?php

use Input;
use Inbound;
use Activity;
use Outbound;
use Productions;
use Carbon\Carbon;
use BaseController;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB as DBS;

class MainController extends BaseController
{

	public function index()
	{



		if (Auth::check() && Auth::user()) {

			$current_date = date('l M j, Y');

			$is_admin 	  = false;

			if (Auth::user()->is_admin) {
				$is_admin = true;
			}

			//Operator View
			$production_count = Productions::where('created_at', 'like', date('Y-m-d') . '%')->count();
			$outbound_count = Outbound::where('created_at', 'like', date('Y-m-d') . '%')->count();
			$inbound_count = Inbound::where('created_at', 'like', date('Y-m-d') . '%')->count();

			//get activities today
			$activities = Activity::where('created_at', 'like', date('Y-m-d') . '%')->orderBy('id', 'desc')->get();

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


	public function inbound_outbound_fullscreen()
	{

		$date = date('l F j, Y');
		$today = date('Y-m-d');
		// $nextday = date('Y-m-d', strtotime(' +1 day'));
		$nextday = date('Y-m-d');
		$hide_header = true;



		$dateSelected = Input::get('selectedDate');
		
		

		if (Input::has('selectedDate')) {

			$inbounds = Inbound::where('schedule', 'like', $dateSelected . '%')->orderBy('schedule', 'ASC')->get();
			$outbounds = Outbound::where('created_at', 'like', $dateSelected . '%')->orderBy('outbound_start_time', 'ASC')->get();

			$count_inbound = 1;
			$count_outbound = 1;
			$countinbound = false;

			return view('fullscreen.inbound_outbound_datalist')->with(compact('inbounds', 'outbounds', 'date', 'nextday', 'today', 'hide_header','count_inbound','count_outbound','countinbound'));

			// $today = date('Y-m-d', strtotime(Input::get('d')));
			// $date = date('l F j, Y', strtotime(Input::get('d')));
			// //$nextday = date('Y-m-d', strtotime(Input::get('d').' +1 day'));
			// $nextday = date('Y-m-d', strtotime(Input::get('d')));

			//return view('fullscreen.inbound_outbound_datalist')->with(compact('inbounds', 'outbounds', 'date', 'nextday', 'today', 'hide_header'));
		}




		if (date('l', strtotime($today)) == "Friday") {
			$nextday = date('Y-m-d', strtotime(' +3 day'));
		}
		if (Input::has('d')) {
			$inbounds = Inbound::where('schedule', 'like', Input::get('d') . '%')->orderBy('schedule', 'ASC')->get();
			$outbounds = Outbound::where('created_at', 'like', Input::get('d') . '%')->orderBy('outbound_start_time', 'ASC')->get();


			$today = date('Y-m-d', strtotime(Input::get('d')));
			$date = date('l F j, Y', strtotime(Input::get('d')));
			//$nextday = date('Y-m-d', strtotime(Input::get('d').' +1 day'));
			$nextday = date('Y-m-d', strtotime(Input::get('d')));

			$count_inbound = 1;
			$count_outbound = 1;
			$countinbound = false;
			return view('fullscreen.inbound_outbound')->with(compact('inbounds', 'outbounds', 'date', 'nextday', 'today', 'hide_header','count_inbound','count_outbound','countinbound'));



			// return view('fullscreen.inbound_outbound')->with(compact('inbounds', 'outbounds', 'date', 'nextday', 'today', 'hide_header'));
		} else {
			$inbounds = Inbound::orderBy('schedule', 'ASC')->take(10)->get();
			$outbounds = Outbound::orderBy('outbound_start_time', 'ASC')->take(10)->get();
			$count_inbound = 1;
			$count_outbound = 1;
			$countinbound = false;
			return view('fullscreen.inbound_outbound')->with(compact('inbounds', 'outbounds', 'date', 'nextday', 'today', 'hide_header','count_inbound','count_outbound','countinbound'));

		}
	}

	public function sort_data_column_list()
	{


	

		$date = date('l F j, Y');
		$today = date('Y-m-d');
		// $nextday = date('Y-m-d', strtotime(' +1 day'));
		$nextday = date('Y-m-d');
		$hide_header = true;

		


		$sort_type = $_GET["sort_type"];
		$column_name = $_GET["column_name"];
		$schedule = $_GET["schedule"];
		if ($sort_type == 'desc') {

			
			
			$inbounds = Inbound::where('schedule', 'like', $schedule . '%')->orderBy($column_name, $sort_type)->get();
			$outbounds = Outbound::where('created_at', 'like', $schedule . '%')->orderBy($column_name, $sort_type)->get();

			

			$count_inbound = 5;
			$count_outbound = $outbounds->count()+1;
			$countinbound = true;
			 return view('fullscreen.inbound_outbound_datalist')->with(compact('inbounds', 'outbounds', 'date', 'nextday', 'today', 'hide_header','count_inbound','count_outbound','countinbound'));
	
			//dd($column_name);
		} else{
			$inbounds = Inbound::where('schedule', 'like', $schedule . '%')->orderBy($column_name, $sort_type)->get();
			$outbounds = Outbound::where('created_at', 'like', $schedule . '%')->orderBy($column_name, $sort_type)->get();
			$count_inbound = 5;
			$count_outbound = $outbounds->count()+1;
			$countinbound = false;
			
			return view('fullscreen.inbound_outbound_datalist')->with(compact('inbounds', 'outbounds', 'date', 'nextday', 'today', 'hide_header','count_inbound','count_outbound','countinbound'));
	
		}



		//  if (Input::has('order_by')) {
		// if (Input::has('selectedDate')) {}

		//dd("asdsadasd");
			// dd(Input::has('selectedDate'));
			// $sort_by = $request->get('sortby');
			// $sort_type =  $request->get('sorttype');

			// $inbounds = Inbound::orderBy($column_name, $sort_type)->get();
			// $outbounds = Outbound::orderBy($column_name, $sort_type)->get();

			// foreach ($inbounds as $row) {

			// 	$output = '<td><a href="/customers/' . $row->id . ' ">' . $row->name . '</a></td>
			// 		<td>' . $row->id . '</td>

			// 		<td>
			// 		<a href="#" class="view" title="View" data-toggle="tooltip"><i class="material-icons">&#xE417;</i></a>
			// 		<a href="#" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
			// 		<a href="#" class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
			// 	  </td>
			// 		 ';

			// }
			// echo $output;

			//return view('fullscreen.inbound_outbound_datalist')->with(compact('inbounds', 'outbounds', 'date', 'nextday', 'today', 'hide_header'));
		
			
		
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
			$inbounds = Inbound::where('schedule', 'like', Input::get('d') . '%')->get();
			$today = date('Y-m-d', strtotime(Input::get('d')));
			$date = date('l F j, Y', strtotime(Input::get('d')));
			//$nextday = date('Y-m-d', strtotime(Input::get('d').' +1 day'));
			$nextday = date('Y-m-d', strtotime(Input::get('d')));
		} else {
			$inbounds = Inbound::where('schedule', 'like', date('Y-m-d') . '%')->get();
		}

		return view('fullscreen.inbound')->with(compact('inbounds', 'date', 'nextday', 'today', 'hide_header'));
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
			$outbounds = Outbound::where('created_at', 'like', Input::get('d') . '%')->orderBy('outbound_start_time', 'ASC')->get();
			$inbounds = Inbound::where('schedule', 'like', Input::get('d') . '%')->get();
			$today = date('Y-m-d', strtotime(Input::get('d')));
			$date = date('l F j, Y', strtotime(Input::get('d')));
			$nextday = date('Y-m-d', strtotime(Input::get('d') . ' +1 day'));
		} else {
			$outbounds = Outbound::where('created_at', 'like', date('Y-m-d') . '%')->orderBy('outbound_start_time', 'ASC')->get();
			$inbounds = Inbound::where('schedule', 'like', date('Y-m-d') . '%')->get();
		}

		return view('fullscreen.outbound')->with(compact('inbounds', 'outbounds', 'date', 'nextday', 'today', 'hide_header'));
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

		if (date('D', strtotime($start_date)) == 'Sat') {
			$start_date = date("Y-m-d", strtotime($date . " +3 days"));
		}

		if (date('D', strtotime($start_date)) == 'Sun') {
			$start_date = date("Y-m-d", strtotime($date . " +2 days"));
		}

		while ($date_count <= 5) {
			$query = Productions::where('production_date', 'like', $start_date . '%')->get();

			if (date('D', strtotime($start_date)) == 'Sat') {
				$start_date = date("Y-m-d", strtotime($start_date . " +2 days"));
			}

			if (date('D', strtotime($start_date)) == 'Sun') {
				$start_date = date("Y-m-d", strtotime($start_date . " +1 days"));
			}

			if (!empty($query)) {
				if (count($query) > $max_row) {
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

		if ($next_action == 'next_day') {
			if (date('D', strtotime($date)) == 'Fri') {
				$date 		 = date("Y-m-d", strtotime($date . " + 3 day"));
			} else {
				$date 		 = date("Y-m-d", strtotime($date . " + 1 day"));
			}

			$next_action = "weekly";
		}

		$date = date('l F j, Y', strtotime($date));

		$products = Productions::where('production_date', 'like', date("Y-m-d", strtotime($date)) . '%')->get();
		return view('fullscreen.production_daily')->with(compact('products', 'date', 'next_action', 'hide_header'));
	}

	public function inbound_weekly_fullscreen()
	{
		$date 	     = date('l F j, Y');
		$max_row     = 0;
		$products    = array();
		$hide_header = true;
		$date_count  = 1;

		//$start_date = date("Y-m-d", strtotime($date . " +1 days"));
		$start_date = date("Y-m-d", strtotime($date));

		if (date('D', strtotime($start_date)) == 'Sat') {
			$start_date = date("Y-m-d", strtotime($date . " +3 days"));
		}

		if (date('D', strtotime($start_date)) == 'Sun') {
			$start_date = date("Y-m-d", strtotime($date . " +2 days"));
		}

		while ($date_count <= 5) {
			$query = Inbound::where('created_at', 'like', $start_date . '%')->get();

			if (date('D', strtotime($start_date)) == 'Sat') {
				$start_date = date("Y-m-d", strtotime($start_date . " +2 days"));
			}

			if (date('D', strtotime($start_date)) == 'Sun') {
				$start_date = date("Y-m-d", strtotime($start_date . " +1 days"));
			}

			if (!empty($query)) {
				if (count($query) > $max_row) {
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

	public function outbound_weekly_fullscreen()
	{
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
		while ($date_count <= 5) {
			$query = Outbound::where('created_at', 'like', $start_date . '%')->get();
			/*
			if(date('D', strtotime($start_date)) == 'Sat') {
				$start_date = date("Y-m-d", strtotime($start_date . " +2 days"));
			}

			if(date('D', strtotime($start_date)) == 'Sun') {
				$start_date = date("Y-m-d", strtotime($start_date . " +1 days"));
			}
*/
			if (!empty($query)) {
				if (count($query) > $max_row) {
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
