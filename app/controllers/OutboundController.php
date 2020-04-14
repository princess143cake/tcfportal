<?php

/**
* Outbound controller
*/

class OutboundController extends BaseController
{
	
	public function index()
	{
		if (Input::has('d')) {
			$outbounds = Outbound::where('created_at', 'like', Input::get('d').'%')->orderBy('outbound_start_time', 'ASC')->get();
			$date = date('l F j, Y', strtotime(Input::get('d')));
		} else {
			$outbounds = Outbound::where('created_at', 'like', date('Y-m-d').'%')->orderBy('outbound_start_time', 'ASC')->get();
			$date = date('l F j, Y');
		}

		
		return view('operator.adrian')->with(compact('outbounds', 'date'));
	}

	public function insert()
	{
		$fields = Input::get('fields');
		$fields['outbound_start_time'] = strtotime($fields['outbound_start_time']);

		//Save Data History if new
		$this->saveDataHistory();
		
		//save activity
		Activity::create(['user_id' => Auth::user()->id, 'type' => 'outbound']);

		$outbound = Outbound::create($fields);

		if ($fields['date'] != null) {
			$outbound->created_at = date('Y-m-d H:i:s', strtotime($fields['date']));
			$outbound->save();
		}

		return json_encode($outbound);
	}

	public function delete()
	{
		Outbound::where(['id' => Input::get('id')])->delete();
	}

	public function edit()
	{
		$outbound = Outbound::find(Input::get('id'));
		$outbound->outbound_start_time = $outbound->outbound_start_time ? date('h:i a', $outbound->outbound_start_time) : '';

		return json_encode($outbound);
	}

	public function update()
	{
		$fields = Input::get('fields');
		$fields['outbound_start_time'] = strtotime($fields['outbound_start_time']);

		//Save Data History if new
		$this->saveDataHistory();

		Outbound::where(['id' => Input::get('id')])->update($fields);
		$outbound = Outbound::find(Input::get('id'));
		$outbound->outbound_start_time = $outbound->outbound_start_time ? date('h:i a', $outbound->outbound_start_time) : '';

		return json_encode($outbound);
	}

	// Second Phase ============================================================================

	public function insert_stop()
	{
		$fields = Input::get('fields');
		$fields['outbound_dock_time'] = strtotime($fields['outbound_dock_time']);

		//Save Data History if new
		$this->saveDataHistory();
		
		//save activity
		Activity::create(['user_id' => Auth::user()->id, 'type' => 'outbound']);

		$outbound2 = OutboundSecond::create($fields);

		return json_encode($outbound2);
	}

	public function edit_stop()
	{
		$outbound = OutboundSecond::find(Input::get('id'));
		$outbound->outbound_dock_time = $outbound->outbound_dock_time ? date('h:i a', $outbound->outbound_dock_time) : '';
		return json_encode($outbound);
	}

	public function update_stop()
	{
		$fields = Input::get('fields');
		$fields['outbound_dock_time'] = strtotime($fields['outbound_dock_time']);

		//Save Data History if new
		$this->saveDataHistory();

		OutboundSecond::where(['id' => Input::get('id')])->update($fields);
		$outbound = OutboundSecond::find(Input::get('id'));
		return json_encode($outbound);
	}

	public function delete_stop()
	{
		OutboundSecond::where(['id' => Input::get('id')])->delete();
		
	}

	public function sortNumber()
	{
		if(!empty($_POST["data"])) {
			foreach($_POST["data"] as $key => $value) {
				if(!empty($value)) {
					$update = array("id"		  => $value[0],
									"sort_number" => $value[1]
								   );

					$sort_number 			  = OutboundSecond::find($value[0]);
					$sort_number->sort_number = $value[1];
					$sort_number->save();
				}
			}
		}
	}
	public function print($id){
		$data = Outbound::find($id);
		
		$view = view('pdf.outbound')->with( compact('data') );
		return PDF::load($view, 'A4', 'portrait')->show();
	}
}