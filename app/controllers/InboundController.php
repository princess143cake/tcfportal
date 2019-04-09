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