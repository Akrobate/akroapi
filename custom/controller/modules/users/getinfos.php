<?php

class Modules_Users_Getinfos extends CoreController {

	public function init() {

		$modules = $this->getModule();
		$data = array();
		if (users::isConnected()) {
			$iduser = users::getId();
			$query = "SELECT * FROM users WHERE id =" . $iduser  ;
			sql::query($query);
			$data = sql::fetchAssoc();
		}
		$this->assign('user', $data);
	}
}
