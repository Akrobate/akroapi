<?php

class Modules_Users_Login extends CoreController {

	public function init() {

		$modules = $this->getModule();
		$login = request::get('login');
		$password = request::get('password');
		
		if (($login != "") && ( $password != "" )) {
			if (users::connect($login, $password)) {
				url::redirect("home", 'index');		
			}
		}		
	}
}
