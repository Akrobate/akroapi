<?php

class Modules_Users_Logout extends CoreController {

	public function init() {
		users::logout();
		url::redirect("users", 'login');		
	}
}
