<?php

class UserController extends BaseController {

	public function index() {
		$users = User::where('id', '!=', Auth::user()->id)->get();

		return view('user.user')->with(compact('users'));
	}

	public function addUser()
	{
		$return = array();
		$return['status']  = 'success';
		$return['message'] = '';

		$user = new User;

		$user->username = $_POST['fields']['username'];
		$user->password = Hash::make($_POST['fields']['password']);
		$user->name     = $_POST['fields']['name'];
		$user->active   = $_POST['fields']['active'];
		$user->is_admin = $_POST['fields']['is_admin'];
		
		if($user->save()) {
			$return['id'] = $user->id;

			$this->insertUserRights($user->id);

			$return['message'] = 'Successfully Added.';
		} else {
			$return['status']  = 'failed';
			$return['message'] = 'Error occured while inserting.';
		}

		echo json_encode($return);
	}

	public function deleteUser()
	{
		$return = array();
		$return['status']  = 'success';
		$return['message'] = '';

		$users = User::find($_POST['fields']['id']);

		if($users->delete()) {
			$return['message'] = 'Successfully Deleted.';
		} else {
			$return['status']  = 'failed';
			$return['message'] = 'Error occured while deleting.';
		}

		echo json_encode($return);
	}

	public function editUser()
	{
		$return 		   = array();
		$return['status']  = 'success';
		$return['message'] = '';

		$user = User::find($_POST['fields']['id']);

		$user->username = $_POST['fields']['username'];
		$user->name 	= $_POST['fields']['name'];
		$user->active   = $_POST['fields']['active'];
		$user->is_admin = $_POST['fields']['is_admin'];
		
		if($user->save()) {
			$this->updateUserRights($_POST['fields']['id']);
			$return['message'] = 'Successfully Updated.';
		} else {
			$return['status']  = 'failed';
			$return['message'] = 'Error occured while inserting.';
		}

		echo json_encode($return);
	}

	public function editSettings()
	{
		$return 		   = array();
		$return['status']  = 'success';
		$return['message'] = '';

		$user = User::find($_POST['fields']['id']);

		$user->password = Hash::make($_POST['fields']['password']);
		
		if($user->save()) {
			$return['message'] = 'Successfully Updated.';
		} else {
			$return['status']  = 'failed';
			$return['message'] = 'Error occured while inserting.';
		}

		echo json_encode($return);
	}

	private function insertUserRights($user_id)
	{
		$access_rights = array('production' => 1,
							   'outbound' 	=> 2,
							   'inbound' 	=> 3,
							   'history'	=> 4,
							   'production-status' 	=> 5
							  );

		$rights 	   = $_POST['access_rights'];
		$data   	   = array();

		if(!empty($rights)) {
			foreach($rights as $key => $value) {
				$data[] = array('action_rights_id' => $access_rights[$key],
								'user_id'		   => $user_id,
								'grant' 		   => $value
								);
			}
		}

		UserAccessRights::insert($data);
	}

	private function updateUserRights($user_id)
	{
		$access_rights = array('production' => 1,
							   'outbound' 	=> 2,
							   'inbound' 	=> 3,
							   'history'	=> 4,
							   'production-status' => 5
							  );

		$rights = $_POST['access_rights'];

		if(!empty($rights)) {
			foreach($rights as $key => $value) {
				//print_r($access_rights[$key]); exit;
				DB::table('user_access_rights')
				            ->where('action_rights_id', $access_rights[$key])
				            ->where('user_id', $user_id)
				            ->update(array('grant' => $value));
			}
		}
	}
}
