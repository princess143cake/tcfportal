<?php

use App\Production;

class ProductionController extends BaseController {

	public function index() {
		echo "operator";
	}

	public function production()
	{
		$date = date("Y-m-d");

		if(!empty($_GET['product-date'])) {
			$date = date( "Y-m-d",strtotime($_GET['product-date']));
		}

		$products = Productions::where('production_date', 'like', $date.'%')->get();

		return view('production.production')->with(compact('products', 'date'));
	}

	public function productionWeekly()
	{
		$date 	    = date("Y-m-d");
		$products   = array();
		$max_row    = 0;
		$date_count = 1;

		if(!empty($_GET['product-date'])) {
			$date = date( "Y-m-d",strtotime($_GET['product-date']));
		}

		$start_date = date("Y-m-d", strtotime($date . " +1 days"));

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
/* //old code - modified by job
		if(date('D', strtotime($date)) == 'Mon') {
			$start_date = $date;
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
		return view('production.productionWeekly')->with(compact('products', 'date', 'max_row'));
	}

	public function addProduction() {
		$return = array();
		$return['status']  = 'success';
		$return['message'] = '';

		$productions = new Productions;

		$productions->production_date    	  = date("Y-m-d", strtotime($_POST['fields']['production_date']));
		$productions->production_product 	  = $_POST['fields']['production_product'];
		$productions->production_customer 	  = $_POST['fields']['production_customer'];
		$productions->production_pack_size    = $_POST['fields']['production_pack_size'];
		$productions->production_product_size = $_POST['fields']['production_product_size'];
		$productions->production_cases 	      = $_POST['fields']['production_cases'];
		$productions->production_skids 	      = $_POST['fields']['production_skids'];
		$productions->production_shift 	      = $_POST['fields']['production_shift'];
		$productions->production_status 	  = $_POST['fields']['production_status'];
		$productions->production_notes 	      = $_POST['fields']['production_notes'];
		
		//Save Data History if new
		$this->saveDataHistory();

		//save activity
		Activity::create(['user_id' => Auth::user()->id, 'type' => 'production']);

		if($productions->save()) {
			$return['id'] = $productions->id;

			$return['message'] = 'Successfully Added.';
		} else {
			$return['status']  = 'failed';
			$return['message'] = 'Error occured while inserting.';
		}

		echo json_encode($return);
	}

	public function editProduction()
	{
		$return 		   = array();
		$return['status']  = 'success';
		$return['message'] = '';

		$productions = Productions::find($_POST['fields']['id']);

		$productions->production_date    	  = $_POST['fields']['production_date'];
		$productions->production_product 	  = $_POST['fields']['production_product'];
		$productions->production_customer 	  = $_POST['fields']['production_customer'];
		$productions->production_pack_size    = $_POST['fields']['production_pack_size'];
		$productions->production_product_size = $_POST['fields']['production_product_size'];
		$productions->production_cases 	      = $_POST['fields']['production_cases'];
		$productions->production_skids 	      = $_POST['fields']['production_skids'];
		$productions->production_shift 	      = $_POST['fields']['production_shift'];
		$productions->production_status 	  = $_POST['fields']['production_status'];
		$productions->production_notes 	      = $_POST['fields']['production_notes'];
		
		//Save Data History if new
		$this->saveDataHistory();

		if($productions->save()) {
			$return['message'] = 'Successfully Added.';
		} else {
			$return['status']  = 'failed';
			$return['message'] = 'Error occured while inserting.';
		}

		echo json_encode($return);
	}

	public function editProductionStatus()
	{
		$return 		   = array();
		$return['status']  = 'success';
		$return['message'] = '';

		$productions = Productions::find($_POST['fields']['id']);

		$productions->production_status = $_POST['fields']['production_status'];
		
		//Save Data History if new
		// $this->saveDataHistory();

		if($productions->save()) {
			$return['message'] = 'Successfully Added.';
		} else {
			$return['status']  = 'failed';
			$return['message'] = 'Error occured while inserting.';
		}

		echo json_encode($return);
	}

	public function deleteProduction()
	{
		$return = array();
		$return['status']  = 'success';
		$return['message'] = '';

		$productions = Productions::find($_POST['fields']['id']);

		if($productions->delete()) {
			$return['message'] = 'Successfully Deleted.';
		} else {
			$return['status']  = 'failed';
			$return['message'] = 'Error occured while deleting.';
		}

		echo json_encode($return);
	}
}
