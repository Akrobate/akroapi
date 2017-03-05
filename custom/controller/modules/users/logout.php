<?php

class Modules_Users_Logout extends CoreController {

	public function init() {
		if (users::logout()) {
			$this->assign('status', 'logout');
		} else {
			$this->assign('status', 'error');
		}
	}
}
