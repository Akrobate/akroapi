<?php

/**
 *
 *	Controlleur générique d'enregistrement
 *	Permet l'enregistrement de toutes les données
 *
 *	@author	Artiom FEDOROV
 *	@date	2014
 *
 *
 */

 
class Modules_Words_Save extends CoreController {

	/** 
	 *	@brief	Méthode init qui sauvegarde les données passées en params
	 *
	 */

	public function init() {

		$params = $this->getParams();
		
		/**	
		 *	Partie s'occupant de chercher l'utilisateur
		 *
		 */
		
		if (isset($params->hash)) {
			$hash = $params->hash;
			$owner_id = $this->getUserIdFromHash($hash);
			if($owner_id === false) {
				$owner_id = $this->createUser($hash);
			}
			$params->id_owner = $owner_id;	
		}
		
		
		$orm = new OrmNode();
		$fields = OrmNode::getFieldsFor($this->getModule());
		$data = array();


		// $id = $params->id;
		$id = "";
		
		// On nettoye les parametres d'eventuels champs non gérés
		// Pour obtenir un data object compatible avec l'upser		
		foreach($fields as $fieldname=>$field) {
			if (isset($params->{$fieldname})) {
				$data[$fieldname] = $params->{$fieldname};
			}
		}
		
		$allFields = array_keys($fields);
		if ($id != "") {
			$allFields[] = 'id';
			$data['id'] = $id;
		}

		$rez = $orm->upsert($this->getModule(), $allFields, $data);	

		// Si id est set tout s'est bien passé		
		if ($rez['id'] != 0) {
			$id = $rez['id'];
			$this->assign('id', $id);
			$this->getCallerClass()->result = "success2";
		} else {
			$this->getCallerClass()->result = "fail2";
			$this->assign('id', $id);
		}
	
	}
	
	
	/** 
	 *	@brief	Méthode 
	 *
	 */

	public function getUserIdFromHash($hash) {
	
		if ($hash == "") {
			return false;
		}
	
//		$module = sql::escapeString($this->getModule());
		$hash = sql::escapeString($hash);
				
		$query = "SELECT * FROM owner WHERE owner = '$hash'";
		sql::query($query);
		$data = sql::allFetchArray();
		
		if (sql::nbrRows() == 1) {
			return $data[0]['id'];
		} else {
			return false;
		}
	
	}
	
	
	
	/** 
	 *	@brief	Méthode init qui sauvegarde les données passées en params
	 *
	 */

	public function createUser($hash) {

		if ($hash == "") {
			return false;
		}
		$hash = sql::escapeString($hash);		
		$query = "INSERT INTO owner (owner, created) VALUES ('$hash', NOW() ); ";
		sql::query($query);
		$id = sql::lastId();;

		if ($id) {
			return $id;
		} else {
			return false;
		}	
	}


}
