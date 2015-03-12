<?php
/**
 *	Controlleur générique d'enregistrement
 *	Permet l'enregistrement de toutes les données
 *
 *	@author	Artiom FEDOROV
 *	@date	2014
 */
 
class Module_Save extends CoreController {

	/** 
	 *	@brief	Méthode init qui sauvegarde les données passées en params
	 *
	 */

	public function init() {
	
		
		$orm = new OrmNode();		
		$fields = OrmNode::getFieldsFor($this->getModule());
		
		$data = array();
		$params = $this->getParams();

		$id = $params['id'];

		// On nettoye les parametres d'eventuels champs non gérés
		// Pour obtenir un data object compatible avec l'upser
		
		foreach($fields as $fieldname=>$field) {
			$data[$fieldname] = $params[$fieldname];
		}
		

		
		$allFields = array_keys($fields);
		
		if ($id != "") {
			$allFields[] = 'id';
			$data['id'] = $id;
		}
		

		$rez = $orm->upsert($this->getModule(), $allFields, $data);	
//		print_r($rez);
		
		if ($rez['id'] != 0) {
			$id = $rez['id'];
		}

		//echo("========" . $id);
		//url::redirect($this->getModule(), 'view', $id);	
		
	}
}
