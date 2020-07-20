<?php

/**
* Inbound Schedule
*/
class InboundController extends BaseController
{
	
	function index()
	{

		if (Input::has('d')) {
			$inbounds = Inbound::where('schedule', 'like', Input::get('d').'%')->get();
			$date = date('l F j, Y', strtotime(Input::get('d')));
		} else {
			$inbounds = Inbound::where('schedule', 'like', date('Y-m-d').'%')->get();
			$date = date('l F j, Y');
		}
		return view('operator.inboundSchedule')->with(compact('inbounds', 'date'));
	}

	public function combined(){

		if (Input::has('d')) {
			$inbounds = Inbound::where('schedule', 'like', Input::get('d').'%')->get();
			$outbounds = Outbound::where('created_at', 'like', Input::get('d').'%')->orderBy('outbound_start_time', 'ASC')->get();
			$inbound_shipping = InboundShipping::where('created_at', 'like', Input::get('d').'%')->get();
			$date = date('l F j, Y', strtotime(Input::get('d')));
		} else {
			$inbounds = Inbound::where('schedule', 'like', date('Y-m-d').'%')->get();
			$outbounds = Outbound::where('created_at', 'like', date('Y-m-d').'%')->orderBy('outbound_start_time', 'ASC')->get();
			$inbound_shipping = InboundShipping::where('created_at', 'like', date('Y-m-d').'%')->get();
			$date = date('l F j, Y');
		}	

		return view('operator.combined')->with(compact('inbounds','inbound_shipping','outbounds','date'));
	}

	// public function get_combined_records(){			

	// 	$option = Input::get('option');
	// 	if (Input::get('option') == "outbound_schedule") {
			
	// 		if (Input::has('d')) {
	// 			$outbounds = Outbound::where('created_at', 'like', Input::get('d').'%')->orderBy('outbound_start_time', 'ASC')->get();
	// 			$date = date('l F j, Y', strtotime(Input::get('d')));
	// 		} else {
	// 			$outbounds = Outbound::where('created_at', 'like', date('Y-m-d').'%')->orderBy('outbound_start_time', 'ASC')->get();
	// 			$date = date('l F j, Y');
	// 		}			
	
	// 		$view = view('operator.outboundSchedule')->with(compact('outbounds','date','option'));
	// 	}

	// 	if (Input::get('option') == "inbound_shipping") {
			
	// 		if (Input::has('d')) {
	// 			$inbounds = InboundShipping::where('created_at', 'like', Input::get('d').'%')->get();
	// 			$date = date('l F j, Y', strtotime(Input::get('d')));
	// 		} else {
	// 			$inbounds = InboundShipping::where('created_at', 'like', date('Y-m-d').'%')->get();
	// 			$date = date('l F j, Y');
	// 		}	
	// 		$view = view('inbound_shipping.inbound_shipping')->with(compact('inbounds', 'date','option'));

	// 	}

	// 	if (Input::get('option') == "inbound_schedule") {
			
	// 		if (Input::has('d')) {
	// 			$inbounds = Inbound::where('schedule', 'like', Input::get('d').'%')->get();
	// 			$date = date('l F j, Y', strtotime(Input::get('d')));
	// 		} else {
	// 			$inbounds = Inbound::where('schedule', 'like', date('Y-m-d').'%')->get();
	// 			$date = date('l F j, Y');
	// 		}
	// 		$view =  view('operator.inboundSchedule')->with(compact('inbounds', 'date','option'));

	// 	}
	// 	if (Input::get('option') == "0") {
	// 		$date = date('Y-m-d');

	// 	 	$view = view('layouts.plain')->with(compact('date'));
	// 	}
	// 	$response = [            
	// 		'view' => $view->render()
	// 	];
	// 	return \Response::json($response);
	// }

	public function insert()
	{
		$fields = Input::get('fields');
		$fields['inbound_eta'] = strtotime($fields['inbound_eta']);
		// $fields['inbound_arrival_to_port'] = date('Y-m-d', strtotime( $fields['inbound_arrival_to_port'] ));
		// $fields['inbound_arrival_to_destination'] = date('Y-m-d', strtotime( $fields['inbound_arrival_to_destination'] ));
		// $fields['inbound_pickup_appointment'] = date('Y-m-d H:i:a', strtotime( $fields['inbound_pickup_appointment']));
		
		//Save Data History if new
		$this->saveDataHistory();

		//save activity
		Activity::create(['user_id' => Auth::user()->id, 'type' => 'inbound']);

		$inbound = Inbound::create($fields);

		
		if ($fields['date'] != null) {
			$inbound->created_at = date('Y-m-d H:i:s', strtotime($fields['date']));
			$inbound->save();
		}

		return json_encode($inbound);
	}

	public function delete()
	{
		Inbound::where(['id' => Input::get('id')])->delete();
	}

	public function edit()
	{
		$inbound = Inbound::find(Input::get('id'));
		$inbound->inbound_eta = $inbound->inbound_eta ? date('h:i a', $inbound->inbound_eta) : '';
		return json_encode($inbound);
	}
	
	public function update()
	{
		$fields 			   = Input::get('fields');

		$fields['inbound_eta'] = strtotime($fields['inbound_eta']);
		$fields['created_at']  	   = date("Y-m-d", strtotime($fields['date']));
		// $fields['inbound_arrival_to_port'] = date('Y-m-d', strtotime( $fields['inbound_arrival_to_port'] ));
		// $fields['inbound_arrival_to_destination'] = date('Y-m-d', strtotime( $fields['inbound_arrival_to_destination'] ));
		// $fields['inbound_pickup_appointment'] = date('Y-m-d H:i:s', strtotime( $fields['inbound_pickup_appointment']));

		unset($fields['date']);

		//Save Data History if new
		//$this->saveDataHistory();

		Inbound::where(['id' => Input::get('id')])->update($fields);
		$inbound = Inbound::find(Input::get('id'));
		$inbound->inbound_eta = $inbound->inbound_eta ? date('h:i a', $inbound->inbound_eta) : '';
		return json_encode($inbound);
	}

}