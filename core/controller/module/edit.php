<?php

/**
 *	Controlleur générique d'edition
 *	Ce controlleur initialise la liste des champs
 *	@author	Artiom FEDOROV
 *
 */
 
class Module_Edit extends CoreController {


	/**
	 *	Methode qui prepare l'ensemble des champs 
	 *	En mode edition
	 *
	 */

	public function init() {
		
		$id = request::get('id');
		$fields = OrmNode::getFieldsFor($this->getModule());
		$data = array();
		
		if ($id != "") {
			$orm = new OrmNode();
			$content = $orm->getData($this->getModule(), $id);
			$data = OrmNode::dataFieldsAdapter($content, $fields, 'edit', 'rendered');		
		} else {
			$data = OrmNode::dataFieldsAdapterEmpty($fields, 'edit', 'rendered');
			$id=0;
		}
		
		// Assignation des variables pour le template
		$this->assign('fields', $data);
		$this->assign('id', $id);
	}
}
