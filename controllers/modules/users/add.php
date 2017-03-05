<?php

/**
 *	Controlleur générique d'enregistrement
 *	Permet l'enregistrement de toutes les données
 *
 *	@author	Artiom FEDOROV
 *	@date	2014
 */

 
class Modules_Users_Add extends CoreController {

	/** 
	 *	@brief	Méthode init qui sauvegarde les données passées en params
	 *
	 */

	public function init() {

			$orm = new OrmNode();		
			$fields = OrmNode::getFieldsFor($this->getModule());
			$data = array();
			$params = $this->getParams();

			// On nettoye les parametres d'eventuels champs non gérés
			// Pour obtenir un data object compatible avec l'upser		
			foreach($fields as $fieldname=>$field) {
				if (isset($params->{$fieldname})) {
					$data[$fieldname] = $params->{$fieldname};
				}
			}

			$rez = $orm->upsert($this->getModule(), array_keys($data), $data);	

			if ($params->usertype == "employe") {
				$query = "INSERT INTO groupsusers (id_user, id_group) VALUES ({$rez['id']}, 1)";
				sql::query($query);
			}


			// Si id est set tout s'est bien passé		
			if ($rez['id'] != 0) {
				$id = $rez['id'];
				$this->assign('id', $id);
				$this->getCallerClass()->result = "success";
			} else {
				$this->getCallerClass()->result = "fail";
				$this->assign('id', $id);
			}

		
	}
}
