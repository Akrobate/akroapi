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

 
class Modules_Words_Bookmark extends CoreController {

	/** 
	 *	@brief	Méthode init qui sauvegarde les données passées en params
	 *
	 */

	public function init() {

		$params = $this->getParams();
		
		$id_trash = $params->id;
		
		/**	
		 *	Partie s'occupant de chercher l'utilisateur
		 *
		 */
		
		if (isset($params->hash)) {
			$hash = $params->hash;
			$owner_id = users::getUserIdFromHash($hash);
			if($owner_id === false) {
				$owner_id = users::createUser($hash);
			}
			$params->id_owner = $owner_id;	
		}
		
		
		$orm = new OrmNode();
		$data = array();

		$data['id_owner'] = $owner_id;
		$data['id_word'] = $id_trash;
		
		$allFields = array_keys($data);
		
		$rez = $orm->upsert('bookmarks', $allFields, $data);	

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
