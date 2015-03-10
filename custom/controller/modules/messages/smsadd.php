<?php

/**
 *	Cette classe est le controlleur qui gere
 *	l'ajout de sms depuis dans le crm
 *	par appel depuis un appareil exterieur
 *	
 *	Recupere simplement deplus l'url en get les parametres
 *		phone
 *		text
 *
 *	Pour insertion en base dans le module messages		
 *
 *	@author	Artiom FEDOROV
 *	@date	2014
 *
 */

class Modules_Messages_Smsadd extends CoreController {

	public $autoAttach = array(
							'contacts'=>array('telephone')				
							);
			//'users'=>array('telephone')
			
			
	/**
	 *	Surchage principale
	 *
	 */

	public function init() {
	
		$orm = new OrmNode();		
		$fields = OrmNode::getFieldsFor($this->getModule());		
		$data = array();
				
		$data['mobilephone'] = request::get('phone');
		$data['message'] = request::get('text');
		
		$id_contact = $this->tryToAttach('contacts', $data['mobilephone']);
		
		print_r($id_contact);
		
		if ($id_contact != 0) {
			$data['id_contact'] = $id_contact;
		}
		
		$allFields = array_keys($fields);
		$rez = $orm->upsert($this->getModule(), $allFields, $data);	

		// On est en mode "Pseudo API" donc je kill l'execution a la fin volontairement
		exit();
	}

	
	/**
	 *	Methode qui permet d'attacher le nouveau enregistrement
	 *	Aux elements definis dans
	 *	autoAttach
	 */
	
	public function tryToAttach($module, $value) {

		$orm = new OrmNode();
		$fields = $this->autoAttach[$module];
		$arr = array();
		foreach ($fields as $field) {
			$arr[$field] = $value;		
		}
		$data =	$orm->findDataFromFields($module, $arr) ;
		if (isset($data[0]['id'])) {
			return $data[0]['id'];
		} else {
			return 0;
		}
		
	}
	
}
