<?php
/**
 * Application Helpers
 */

if (!function_exists('view')) {

	function view($view) {

		return View::make($view);

	}
	
}

if (!function_exists('user_access_rights')) {

    function user_access_rights($title_id) {
        if(Auth::user()->is_admin == 1) {
            if($title_id == 5) {
                return "false";
            }

            return "true";
        }

        $rights =  UserAccessRights::where('user_id', '=', Auth::user()->id)->where('action_rights_id', '=', $title_id)->first();

        if(empty($rights->grant)) {
            Auth::logout();
            return Redirect::to('/');
        }

        return $rights->grant;
    }
    
}