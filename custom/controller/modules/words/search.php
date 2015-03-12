<?php

/**
 *	Controlleur générique de visualisation de la liste de resultats
 *	Permet la visualisation de toutes les données
 *	De l'enregistrement
 *
 *	@author	Artiom FEDOROV
 *	@date	2014
 */

class Modules_Words_Search extends CoreController {


	/** 
	 *	@brief	Méthode init qui recupere la liste de resultats
	 *	@details	Affiche la liste de contenus
	 *
	 * //$orm->start_limit = $this->start;
	 *	//$orm->nbr_limit = $this->nbr;		
	 *
	 *
	 */

	public function init() {

		$params = $this->getParams();

		$longitude = $params->longitude;
		$latitude = $params->latitude;
		$altitude = $params->altitude;

		$orm = new OrmNode();
		$module = $this->getModule();
		
		$listFields = OrmNode::getFieldsFor($module);
		$listFields['id'] = array('label'=>'id', 'type'=>'int');
		
		$orm->setFilter(" (altitude = '$altitude') AND (longitude = '$longitude') AND (latitude = '$latitude') ");
		$content = $orm->getAllData($this->getModule(), $listFields);
		//$this->total = $orm->total;
		
		$this->assign('found', $content);
		$this->getCallerClass()->result = "success";
		
	}

}
