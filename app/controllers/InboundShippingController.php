<?php

class InboundShippingController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		if (Input::has('d')) {
			$inbounds = InboundShipping::where('created_at', 'like', Input::get('d').'%')->get();
			$date = date('l F j, Y', strtotime(Input::get('d')));
		} else {
			$inbounds = InboundShipping::where('created_at', 'like', date('Y-m-d').'%')->get();
			$date = date('l F j, Y');
		}
		return view('inbound_shipping.inbound_shipping')->with(compact('inbounds', 'date'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function insert()
	{
		//
		$fields = Input::get('fields');
		// $fields['inbound_eta'] = strtotime($fields['inbound_eta']);
		
		
		//Save Data History if new
		$this->saveDataHistory();

		//save activity
		Activity::create(['user_id' => Auth::user()->id, 'type' => 'InboundShipping']);

		$inbound = InboundShipping::create($fields);	
		$inbound->created_at = date('Y-m-d H:i:s');
		$inbound->save();
		

		return json_encode($inbound);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit()
	{
		//
		$inbound = InboundShipping::find(Input::get('id'));
		$inbound->inbound_eta = $inbound->inbound_eta ? date('h:i a', $inbound->inbound_eta) : '';
		return json_encode($inbound);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update()
	{
		//
		$fields 			   = Input::get('fields');

		// $fields['inbound_eta'] = strtotime($fields['inbound_eta']);
		$fields['created_at']  	   = date('Y-m-d H:i:s');
		// $fields['inbound_arrival_to_port'] = date('Y-m-d', strtotime( $fields['inbound_arrival_to_port'] ));
		// $fields['inbound_arrival_to_destination'] = date('Y-m-d', strtotime( $fields['inbound_arrival_to_destination'] ));
		// $fields['inbound_pickup_appointment'] = date('Y-m-d H:i:s', strtotime( $fields['inbound_pickup_appointment']));

		unset($fields['date']);

		//Save Data History if new
		//$this->saveDataHistory();=

		InboundShipping::where(['id' => Input::get('id')])->update($fields);
		$inbound = InboundShipping::find(Input::get('id'));
		$inbound->inbound_eta = $inbound->inbound_eta ? date('h:i a', $inbound->inbound_eta) : '';
		return json_encode($inbound);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete()
	{
		//
		InboundShipping::where(['id' => Input::get('id')])->delete();
	}


}
