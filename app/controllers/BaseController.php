<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	public function loginUser($credentials)
	{
		$username = $credentials['username'];
		$password = $credentials['password'];

		$user = User::where(['username' => $username])->first();
		
		if ($user && Hash::check($password, $user->password)) {
			// exists
			$user['auth'] = 'valid';

			// exsits but inactive
			if ($user->active != 1) {
				$user['auth'] = 'inactive';
			}
		} else {
			//does not exists
			$user['auth'] = 'invalid';
		}

		return $user;
	}

	public function saveDataHistory()
	{
		$repetitive = Input::get('repetitive');
		$data_history = [];

		if(!empty($repetitive)) {
			foreach ($repetitive as $rep) {
				$data_history['field'] = $rep['field'];
				$data_history['value'] = $rep['value'];
				if ($rep['value']) {
					DataHistory::firstOrCreate($data_history);
				}
			}
		}
	}

}
