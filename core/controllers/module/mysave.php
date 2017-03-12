<?php

/**
 *	Controlleur générique d'enregistrement
 *	Permet l'enregistrement de toutes les données
 *
 *	@author	Artiom FEDOROV
 *	@date	2014
 */


class Module_Mysave extends CoreController {

	/**
	 *	@brief	Méthode init qui sauvegarde les données passées en params
	 *
	 */

	public function init() {

		$orm = new OrmNode();
		$fields = OrmNode::getFieldsFor($this->getModule());
		$data = array();
		$params = $this->getParams();

		if (isset($params->id)) {
            $id = $params->id;
        } else {
            $id = null;
        }

		// On nettoye les parametres d'eventuels champs non gérés
		// Pour obtenir un data object compatible avec l'upser
		foreach($fields as $fieldname=>$field) {
			if (isset($params->{$fieldname})) {
				$data[$fieldname] = $params->{$fieldname};
			}
		}

		$allFields = array_keys($fields);
		if ($id !== null) {
			$allFields[] = 'id';
			$data['id'] = $id;
		}

        $data['owner_user_id'] = users::getId();
        logger::log("uderid " . users::getId() . "\n");
        logger::log(print_r($allFields, 1));
        logger::log(print_r( $data, 1));
		$rez = $orm->upsert($this->getModule(), $allFields, $data);

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
