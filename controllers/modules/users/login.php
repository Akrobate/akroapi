<?php

class Modules_Users_Login extends CoreController {

	public function init() {

		$modules = $this->getModule();
		$params = $this->getParams();
		
		$login = $params->login;
		$password = $params->password;
				
		if (($login != "") && ( $password != "" )) {
			if (users::connect($login, $password)) {
				$this->assign('status', 'connected');
			} else {
				$this->assign('status', 'invalid');
			}
		}		
	}
}
