<?php

/**
 *	Controlleur générique de visualisation de la liste de resultats
 *	Permet la visualisation de toutes les données
 *	De l'enregistrement
 *
 *	@author	Artiom FEDOROV
 *	@date	2014
 */

class Modules_Words_Index extends CoreController {


	/** 
	 *	@brief	Méthode init qui recupere la liste de resultats
	 *	@details	Affiche la liste de contenus
	 *
	 */

	public function init() {
		$id = request::get('id');
		$orm = new OrmNode();
		$module = $this->getModule();
		//$orm->start_limit = $this->start;
		//$orm->nbr_limit = $this->nbr;		
		
		//print_r($listFields);		
		//$orm->setFilter($this->filter);
		
		$listFields = OrmNode::getFieldsFor($module);
		$listFields['id'] = array('label'=>'id', 'type'=>'int');
		$content = $orm->getAllData($this->getModule(), $listFields);
		
		
		//print_r($content);
		
		//$this->total = $orm->total;		
		$this->assign('listContent', $content);
		$this->getCallerClass()->result = "customanswer";
		
		
	}

}
